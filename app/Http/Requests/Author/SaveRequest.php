<?php

namespace App\Http\Requests\Author;

use App\Http\Requests\AbstractRequest;

class SaveRequest extends AbstractRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'surname' => ['required'],
        ];
    }

    public function rData(): array
    {
        return $this->only(['name', 'surname']);
    }
}
