<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Book\SaveRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use App\Table\Columns\Text as TText;
use App\Form\Fields\{
    Checkbox as FCheckbox,
    Select as FSelect,
    Text as FText,
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
            'submit_url' => !$model ? route('api.v1.book.store') : route('api.v1.book.update', ['book' => $model]),
            'breadcrumb' => [
                ['label' => __('Books'), 'url' => route('book.index')],
                ['label' => !$model ? __('Create book') : __('Edit book')]
            ],
            'fields' => [
                (new FText('title', __('Title')))->required()->placeholder(__('Book title')),
                (new FCheckbox('is_borrowed', __('Is borrowed'))),
                (new FSelect('author_id', __('Author')))->options(Author::getOptions()),
            ]
        ];
    }

    protected function getListingSchema(): array
    {
        return [
            'title' => __('Books'),
            'columns' => [
                new TText('id', __('Id')),
                new TText('title', __('Title')),
                new TText('author', __('Author')),
                new TText('is_borrowed_text', __('Is borrowed')),
            ],
        ];
    }

    public function store(SaveRequest $request): JsonResponse
    {
        return parent::storeModel($request);
    }

    public function update(SaveRequest $request, int $id): JsonResponse
    {
        return parent::updateModel($request, $id);
    }

    // toggle borrow book
    public function borrow(Book $book): JsonResponse
    {
        try {
            $book->update(['is_borrowed' => !$book->getAttributes()['is_borrowed']]);

            return $this->apiSuccessHandler('success_borrow_book');
        } catch (\Exception $exception) {
            return $this->apiErrorHandler($exception);
        }
    }
}
