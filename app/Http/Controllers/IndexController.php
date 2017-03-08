<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class IndexController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers
 */
class IndexController extends Controller
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (is_auth()) {
            return response()->redirectToRoute('servers');
        }

        if (access_mode_guest()) {
            return response()->redirectToRoute('servers');
        }

        return response()->redirectToRoute('signin');
    }
}
