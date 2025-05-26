<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class AbstractRequest extends FormRequest
{
    abstract public function rules(): array;

    public function authorize(): bool
    {
        return true;
    }
}
