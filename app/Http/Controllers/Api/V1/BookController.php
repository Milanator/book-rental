<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Book\SaveRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use App\Form\Fields\{
    Checkbox,
    Select,
    Text,
};

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
                (new Select('author_id', __('Author')))->options(Author::getOptions()),
            ]
        ];
    }

    public function store(SaveRequest $request)
    {
        return parent::storeModel($request, __('success_stored_book'));
    }

    public function update(SaveRequest $request, int $id)
    {
        return parent::updateModel($request, __('success_updated_book'), $id);
    }

    public function borrow(Book $book)
    {
        try {
            $book->update(['is_borrowed' => !$book->getAttributes()['is_borrowed']]);

            return $this->apiSuccessHandler('success_borrow_book');
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }
}
