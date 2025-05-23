<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class BaseController extends Controller
{
    /**
     * @param string $component
     * @param array $props
     * @param string|null $asset
     * 
     * @return View
     */
    public function view(string $component, array $props = [], ?string $asset = null): View
    {
        return view('app', [
            'component' => $component,
            'asset' => $asset,
            'props' => $props
        ]);
    }
}
