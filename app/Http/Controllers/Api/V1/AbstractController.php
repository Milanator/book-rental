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

    abstract public static function getListingCacheKey(): string;

    abstract public static function getModelName(): string;

    protected function getModelNamespace(): string
    {
        return "\App\\Models\\{$this->getModelName()}";
    }

    protected function isFirstPage(Request $request): bool
    {
        return is_null($request->page) || $request->page === "1";
    }

    protected function getListingData(Request $request): LengthAwarePaginator
    {
        return $this->getModelNamespace()::listing($request)->paginate($request->limit ?? self::DEFAULT_LIMIT);
    }

    protected function errorHandler(\Exception $exception): JsonResponse
    {
        report($exception);

        return response()->json(['message' => $exception->getMessage(), 'status' => 0], 500);
    }

    public function index(Request $request)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\IndexResource";

            if ($this->isFirstPage($request)) {
                // cached 1. page for fast load
                $data = Cache::remember($this->getListingCacheKey(), self::CACHE_TTL, fn() => $this->getListingData($request));
            } else {
                $data = $this->getListingData($request);
            }

            return $resource::collection(resource: $data);
        } catch (\Exception $exception) {
            $this->errorHandler($exception);
        }
    }

    public function show(string $id)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->getModelName()}\\ShowResource";

            return new $resource($this->getModelNamespace()::detail()->findOrFail($id));
        } catch (\Exception $exception) {
            $this->errorHandler($exception);
        }
    }
}
