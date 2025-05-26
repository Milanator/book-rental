<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index']);

Route::resource('author', AuthorController::class)->only(['index', 'show']);

Route::resource('book', BookController::class)->only(['index', 'show', 'edit', 'create']);

