<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\{
    Controllers\Controller,
    Resources\V1\Book\ShowResource,
};

class BookController extends BaseController
{
    protected string $entity = 'Book';

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

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
