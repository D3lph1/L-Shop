<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Session\SessionManager;

class SpaController extends Controller
{
    /**
     * Renders the root layout.
     *
     * @param Factory        $factory
     * @param SessionManager $session
     *
     * @return View
     */
    public function render(Factory $factory, SessionManager $session): View
    {
        return $factory->make('app', [
            'csrfToken' => $session->token()
        ]);
    }
}
