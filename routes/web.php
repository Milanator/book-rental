<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index']);

Route::resource('author', AuthorController::class)->only(['index', 'edit', 'create']);

Route::resource('book', BookController::class)->only(['index', 'edit', 'create']);

