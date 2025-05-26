<?php

namespace App\Observers;

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Cache;

class BookObserver
{
    public function saved(Book $book): void
    {
        Cache::forget(BookController::getCacheKey());

        Cache::forget(AuthorController::getCacheKey());
    }

    public function deleted(Book $book): void
    {
        Cache::forget(BookController::getCacheKey());

        Cache::forget(AuthorController::getCacheKey());
    }
}
