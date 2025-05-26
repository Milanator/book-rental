<?php

namespace App\Observers;

use App\Http\Controllers\Api\V1\AuthorController;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class AuthorObserver
{
    public function saved(Author $author): void
    {
        Cache::forget(AuthorController::getCacheKey());
    }

    public function deleted(Author $author): void
    {
        Cache::forget(AuthorController::getCacheKey());
    }
}
