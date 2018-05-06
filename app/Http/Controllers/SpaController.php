<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class SpaController extends Controller
{
    /**
     * Renders the root layout.
     *
     * @param Factory $factory
     *
     * @return View
     */
    public function render(Factory $factory): View
    {
        return $factory->make('app');
    }
}
