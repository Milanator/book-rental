<?php

namespace App\Http\Controllers\Api\V1;

use App\Form\Fields\Checkbox;
use App\Form\Fields\Text;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BookController extends AbstractController
{
    protected static function getModelName(): string
    {
        return 'Book';
    }

    public static function getCacheKey(): string
    {
        return 'book_listing';
    }

    protected function getFormSchema(?Model $model = null): array
    {
        return [
            'title' => !$model ? __('Create book') : __('Edit book', ['title' => $model->title]),
            'submit_url' => !$model ? route('api.v1.book.store') : route('api.v1.book.update', ['book' => $model]),
            'fields' => [
                (new Text('title', __('Title')))->required()->placeholder(__('Book title')),
                (new Checkbox('is_borrowed', __('Is borrowed'))),
            ]
        ];
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
            return $this->apiErrorHandler($exception);
        }
    }
}
