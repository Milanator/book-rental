<?php

namespace App\Http\Requests\Book;

class SaveRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'is_borrowed' => [],
            'author_id' => ['required'],
        ];
    }

    public function rData(): array
    {
        return $this->only(['title', 'is_borrowed', 'author_id']);
    }
}
