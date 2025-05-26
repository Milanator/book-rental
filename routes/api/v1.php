<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

// Book
Route::apiResource('book', BookController::class)->only(['index', 'store', 'update', 'show']);

Route::get('/book/{id}/form-builder', [BookController::class, 'formBuilder'])->name('formBuilder');

Route::get('/book/form-builder', [BookController::class, 'formBuilder'])->name('formBuilder');

Route::get('/book/{book}/borrow', [BookController::class, 'borrow'])->name('borrow');

// Author
Route::apiResource('author', AuthorController::class)->only(['index']);