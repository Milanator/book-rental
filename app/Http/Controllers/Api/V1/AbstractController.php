<?php

namespace App\Http\Controllers\Api\V1;

use App\Form\FormBuilder;
use App\Http\Controllers\Controller;
use App\Table\TableBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

abstract class AbstractController extends Controller
{
    protected const string STATUS_ERROR = 'danger';

    protected const string STATUS_SUCCESS = 'success';

    protected const int DEFAULT_LIMIT = 10;

    protected const int CACHE_TTL = 3600; // 1 hour

    // form builder fields
    abstract protected function getFormSchema(?Model $model = null): array;

    abstract protected function getListingSchema(): array;

    // e.g. Author, Book
    abstract protected static function getModelName(): string;

    // listing cache key
    abstract public static function getCacheKey(): string;

    protected function getModelNamespace(): string
    {
        return "\App\\Models\\{$this->getModelName()}";
    }

    protected function getShowResourceNamespace(): string
    {
        return "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\ShowResource";
    }

    protected function getIndexResourceNamespace(): string
    {
        return "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\IndexResource";
    }

    protected function isFiltering(Request $request): bool
    {
        return count(Arr::except($request->query(), ['limit', 'perPage', 'page'])) > 0;
    }

    protected function isFirstPage(Request $request): bool
    {
        return is_null($request->page) || $request->page === "1";
    }

    // check if first page or filter
    protected function returnCachedData(Request $request): bool
    {
        // filtering
        if ($this->isFiltering($request)) {
            return false;
        }

        // is first page
        return $this->isFirstPage($request);
    }

    // fetch paginated listing data by model
    protected function fetchListingData(Request $request): LengthAwarePaginator
    {
        return $this->getModelNamespace()::listing($request)->paginate($request->limit ?? self::DEFAULT_LIMIT);
    }

    protected function apiErrorHandler(\Exception $exception): JsonResponse
    {
        report($exception);

        return response()->json(['message' => $exception->getMessage(), 'status' => self::STATUS_ERROR], 500);
    }

    protected function apiSuccessHandler(string $message): JsonResponse
    {
        return response()->json(['message' => $message, 'status' => self::STATUS_SUCCESS], 200);
    }

    protected function getCachedListingData(Request $request): LengthAwarePaginator
    {
        return Cache::remember($this->getCacheKey(), self::CACHE_TTL, fn() => $this->fetchListingData($request));
    }

    protected function getListingData(Request $request): LengthAwarePaginator
    {
        if ($this->returnCachedData($request)) {
            // cached 1. page for fast load - on modification forget data in observer
            return $this->getCachedListingData($request);
        }

        return $this->fetchListingData($request);
    }

    public function index(Request $request): object
    {
        try {
            $resource = $this->getIndexResourceNamespace();

            return $resource::collection(resource: $this->getListingData($request));
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    public function show(string $id): object
    {
        try {
            $resource = $this->getShowResourceNamespace();

            return new $resource($this->getModelNamespace()::detail()->find($id));
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    public function storeModel(Request $request): JsonResponse
    {
        try {
            $this->getModelNamespace()::store($request);

            return $this->apiSuccessHandler(__("success_stored_" . strtolower($this->getModelName())));
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    public function updateModel(Request $request, int $id)
    {
        try {
            $this->getModelNamespace()::modify($request, $id);

            return $this->apiSuccessHandler(__("success_updated_" . strtolower($this->getModelName())));
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->getModelNamespace()::whereId($id)->first()->delete();

            return $this->apiSuccessHandler(__("success_deleted_" . strtolower($this->getModelName())));
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    // form field builder
    public function formBuilder(Request $request): array|JsonResponse
    {
        try {
            $model = $this->getModelNamespace()::find($request->id);
            $schema = $this->getFormSchema(model: $model);

            return (new FormBuilder($schema))->toArray();
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }

    // listing column builder
    public function listingBuilder(): array|JsonResponse
    {
        try {
            $schema = $this->getListingSchema();

            return (new TableBuilder($schema))->toArray();
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }
}
