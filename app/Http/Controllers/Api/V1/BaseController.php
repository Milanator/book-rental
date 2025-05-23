<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected const int DEFAULT_LIMIT = 10;

    protected string $entity = 'Book';

    public function index(Request $request)
    {
        try {
            $namespace = "\App\\Http\\Resources\\V1\\{$this->entity}\\IndexResource";
            $model = "\App\\Models\\{$this->entity}";

            return $namespace::collection(resource: $model::listing($request)->paginate($request->limit ?? self::DEFAULT_LIMIT));
        } catch (\Exception $exception) {
            report($exception);

            // [TODO] response
        }
    }
}
