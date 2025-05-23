<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\{
    Controllers\Controller,
    Resources\V1\IndexResource,
    Resources\V1\ShowResource,
};

class BookController extends Controller
{
    /**
     * @param Request $request
     * 
     * @return [type]
     */
    public function index(Request $request)
    {
        try {
            return IndexResource::collection(Book::listing($request)->paginate(10));
        } catch (\Exception $exception) {
            report($exception);

            // [TODO] response
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            return new ShowResource(Book::detail()->findOrFail($id));
        } catch (\Exception $exception) {
            report($exception);

            // [TODO] response
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
