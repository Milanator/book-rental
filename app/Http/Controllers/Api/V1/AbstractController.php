<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

abstract class AbstractController extends Controller
{
    protected const int DEFAULT_LIMIT = 10;

    protected const int CACHE_TTL = 3600; // 1 hour

    // listing cache key
    abstract public static function getCacheKey(): string;

    // e.g. Author, Book
    abstract public static function getModelName(): string;

    protected function getModelNamespace(): string
    {
        return "\App\\Models\\{$this->getModelName()}";
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

        return response()->json(['message' => $exception->getMessage(), 'status' => 0], 500);
    }

    protected function getCacheListingData(Request $request)
    {
        return Cache::remember($this->getCacheKey(), self::CACHE_TTL, fn() => $this->getListingData($request));
    }

    public function index(Request $request)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\IndexResource";

            if ($this->isFirstPage($request)) {
                // cached 1. page for fast load - on modification forget data in observer
                $data = $this->getCacheListingData($request);
            } else {
                $data = $this->getListingData($request);
            }

            return $resource::collection(resource: $data);
        } catch (\Exception $exception) {
            $this->apiErrorHandler($exception);
        }
    }

    public function show(string $id)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\ShowResource";

            return new $resource($this->getModelNamespace()::detail()->findOrFail($id));
        } catch (\Exception $exception) {
            $this->apiErrorHandler($exception);
        }
    }
}
