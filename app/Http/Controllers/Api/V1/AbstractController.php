<?php

namespace App\Http\Controllers\Api\V1;

use App\Form\FormBuilder;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

abstract class AbstractController extends Controller
{
    protected const string STATUS_ERROR = 'danger';

    protected const string STATUS_SUCCESS = 'success';

    protected const int DEFAULT_LIMIT = 10;

    protected const int CACHE_TTL = 3600; // 1 hour

    // form builder fields
    abstract protected function getFormSchema(?Model $model = null): array;

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

    // check if first page
    protected function isFirstPage(Request $request): bool
    {
        return is_null($request->page) || $request->page === "1";
    }

    // fetch paginated listing data by model
    protected function getListingData(Request $request): LengthAwarePaginator
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
        return Cache::remember($this->getCacheKey(), self::CACHE_TTL, fn() => $this->getListingData($request));
    }

    public function index(Request $request): object
    {
        try {
            $resource = $this->getIndexResourceNamespace();

            if ($this->isFirstPage($request)) {
                // cached 1. page for fast load - on modification forget data in observer
                $data = $this->getCachedListingData($request);
            } else {
                $data = $this->getListingData($request);
            }

            return $resource::collection(resource: $data);
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

    public function formBuilder(?int $id = null)
    {
        try {
            $model = $this->getModelNamespace()::find($id);
            $schema = $this->getFormSchema(model: $model);

            return (new FormBuilder(formSchema: $schema))->toArray();
        } catch (\Exception $exception) {
            $this->apiErrorHandler($exception);
        }
    }
}
