<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends BaseController
{
    public function index(Request $request)
    {
        try {
            return $this->view('BookIndex');
        } catch (\Exception $exception) {
            report($exception);

            abort(500);
        }
    }
}
