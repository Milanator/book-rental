<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

// Book
Route::get('/book/{id}/form-builder', [BookController::class, 'formBuilder'])->name('formBuilderOnEdit'); // on edit
Route::get('/book/form-builder', [BookController::class, 'formBuilder'])->name('formBuilderOnCreate'); // on create

Route::get('/book/{book}/borrow', [BookController::class, 'borrow'])->name('borrow');

Route::apiResource('book', BookController::class)->only(['index', 'store', 'update', 'show', 'destroy']);

// Author
Route::apiResource('author', AuthorController::class)->only(['index']);