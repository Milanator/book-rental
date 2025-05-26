<?php

namespace App\Http\Controllers;

class BookController extends AbstractController
{
    protected static function getModelName(): string
    {
        return 'Book';
    }
}
