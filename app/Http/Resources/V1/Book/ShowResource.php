<?php

namespace App\Http\Resources\V1\Book;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_merge($this->only(['id', 'title', 'is_borrowed', 'author_id']), [
            'author' => $this->author->full_name,
        ]);
    }
}
