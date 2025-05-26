<?php

namespace App\Http\Controllers\Api\V1;

use App\Form\Fields\Text;
use App\Http\Requests\Author\SaveRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use App\Table\Columns\Text as TText;

class AuthorController extends AbstractController
{
    public static function getCacheKey(): string
    {
        return 'author_listing';
    }

    public static function getModelName(): string
    {
        return 'Author';
    }

    protected function getFormSchema(?Model $model = null): array
    {
        return [
            'submit_url' => !$model ? route('api.v1.author.store') : route('api.v1.author.update', ['author' => $model]),
            'breadcrumb' => [
                ['label' => __('Authors'), 'url' => route('author.index')],
                ['label' => !$model ? __('Create author') : __('Edit author')]
            ],
            'fields' => [
                (new Text('name', __('Firstname')))->required(),
                (new Text('surname', __('Surname')))->required(),
            ]
        ];
    }

    protected function getListingSchema(): array
    {
        return [
            'title' => __('Author'),
            'columns' => [
                new TText('id', __('Id')),
                new TText('full_name', __('Name')),
                new TText('books_count', __('Book count')),
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
}
