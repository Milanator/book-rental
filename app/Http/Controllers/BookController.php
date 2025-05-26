<?php

namespace App\Http\Controllers;

class BookController extends AbstractController
{
    public static function getModelName(): string
    {
        return 'Book';
    }
}
