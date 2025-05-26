<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

abstract class AbstractController extends Controller
{
    abstract protected static function getModelName(): string;

    public function index(Request $request)
    {
        try {
            return $this->view($this->getModelName() . 'Index');
        } catch (\Exception $exception) {
            report($exception);

            abort(500);
        }
    }

    public function edit(int $id)
    {
        try {
            return $this->view($this->getModelName() . 'Edit');
        } catch (\Exception $exception) {
            report($exception);

            abort(500);
        }
    }

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
