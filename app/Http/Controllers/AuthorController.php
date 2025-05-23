<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorController extends BaseController
{
    public function index(Request $request)
    {
        try {
            return $this->view('AuthorIndex');
        } catch (\Exception $exception) {
            report($exception);

            abort(500);
        }
    }
}
