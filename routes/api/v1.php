<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

$crud = ['index', 'store', 'update', 'show', 'destroy'];

// Book
Route::prefix('/book')->group(function () {
    Route::get('/form-builder', [BookController::class, 'formBuilder']);
    Route::get('/listing-builder', [BookController::class, 'listingBuilder']);
    Route::get('/{book}/borrow', [BookController::class, 'borrow']);
});
Route::apiResource('book', BookController::class)->only($crud);

// Author
Route::prefix('/author')->group(function () {
    Route::get('/form-builder', [AuthorController::class, 'formBuilder']);
    Route::get('/listing-builder', [AuthorController::class, 'listingBuilder']);
});
Route::apiResource('author', AuthorController::class)->only($crud);