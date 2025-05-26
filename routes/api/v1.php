<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

// Book
Route::get('/book/{id}/form-builder', [BookController::class, 'formBuilder'])->name('formBuilder'); // on edit
Route::get('/book/form-builder', [BookController::class, 'formBuilder'])->name('formBuilder'); // on create

Route::get('/book/{book}/borrow', [BookController::class, 'borrow'])->name('borrow');

Route::apiResource('book', BookController::class)->only(['index', 'store', 'update', 'show']);

// Author
Route::apiResource('author', AuthorController::class)->only(['index']);