<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthorController::class)->group(function () {
    Route::get('/author', 'index');
    Route::get('/author/{author}', 'show');
});

Route::controller(BookController::class)->group(function () {
    Route::get('/book', 'index');
    Route::get('/book/{book}', 'show');
});

