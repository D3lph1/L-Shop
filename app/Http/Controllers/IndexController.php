<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

/**
 * Class IndexController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * The action responsible for processing the request for URL "/"
     */
    public function index(): RedirectResponse
    {
        if (is_auth() or access_mode_guest()) {
            return response()->redirectToRoute('servers');
        }

        return response()->redirectToRoute('signin');
    }
}
