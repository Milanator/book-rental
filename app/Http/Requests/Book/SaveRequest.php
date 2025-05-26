<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class SaveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required'],
            'is_borrowed' => ['required'],
            'author_id' => ['required'],
        ];
    }
}
