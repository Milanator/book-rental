<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected const int DEFAULT_LIMIT = 10;

    protected string $entity = 'Book';

    protected function getModelNamespace(): string
    {
        return "\App\\Models\\{$this->entity}";
    }

    public function index(Request $request)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->entity}\\IndexResource";

            return $resource::collection(resource: $this->getModelNamespace()::listing($request)->paginate($request->limit ?? self::DEFAULT_LIMIT));
        } catch (\Exception $exception) {
            report($exception);

            // [TODO] response
        }
    }

    public function show(string $id)
    {
        try {
            $resource = "\App\\Http\\Resources\\V1\\{$this->entity}\\ShowResource";

            return new $resource($this->getModelNamespace()::detail()->findOrFail($id));
        } catch (\Exception $exception) {
            report($exception);

            // [TODO] response
        }
    }
}
