<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
            'title' => null,
            'submit_url' => null,
            'fields' => []
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
}
