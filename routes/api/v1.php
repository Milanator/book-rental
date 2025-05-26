<?php

use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\BookController;
use Illuminate\Support\Facades\Route;

// Book
Route::get('/book/form-builder/{id}', [BookController::class, 'formBuilder']); // on edit
Route::get('/book/form-builder', [BookController::class, 'formBuilder']); // on create
Route::get('/book/listing-builder', [BookController::class, 'listingBuilder']);
Route::get('/book/{book}/borrow', [BookController::class, 'borrow']);
Route::apiResource('book', BookController::class)->only(['index', 'store', 'update', 'show', 'destroy']);

// Author
Route::get('/author/form-builder/{id}', [AuthorController::class, 'formBuilder']); // on edit
Route::get('/author/form-builder', [AuthorController::class, 'formBuilder']); // on create
Route::get('/author/listing-builder', [AuthorController::class, 'listingBuilder']);

Route::apiResource('author', AuthorController::class)->only(['index', 'show', 'store', 'update', 'destroy']);