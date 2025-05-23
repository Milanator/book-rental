<?php

use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthorController::class)->group(function () {
    Route::get('/author', 'index');
    Route::get('/author/{author}', 'show');
});

