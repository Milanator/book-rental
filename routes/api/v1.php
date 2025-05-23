<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

Route::apiResource('book', BookController::class);

Route::apiResource('author', AuthorController::class);