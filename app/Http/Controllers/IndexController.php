<?php

namespace App\Http\Controllers;

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
     * The action responsible for processing the request for URL "/"
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        if (is_auth() or access_mode_guest()) {
            return response()->redirectToRoute('servers');
        }

        return response()->redirectToRoute('signin');
    }
}
