<?php

namespace App\Http\Resources\V1\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return array_merge($this->only(['id', 'title', 'is_borrowed_text', 'is_borrowed']), [
            'author' => $this->author->full_name,
        ]);
    }
}
