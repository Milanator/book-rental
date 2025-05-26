<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends AbstractController
{
    public static function getCacheKey(): string
    {
        return 'book_listing';
    }

    public static function getModelName(): string
    {
        return 'Book';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    public function borrow(Book $book)
    {
        try {
            $book->update(['is_borrowed' => !$book->is_borrowed]);

            return response()->json(['status' => 1]);
        } catch (\Exception $exception) {
            return $this->errorHandler($exception);
        }
    }
}
