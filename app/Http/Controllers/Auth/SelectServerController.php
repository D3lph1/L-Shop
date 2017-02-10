<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelectServerController extends Controller
{
    /**
     * Render the select server page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        if ((access_mode_auth()) and !is_auth()) {
            return redirect()->route('signin');
        }

        $qm = \App::make('qm');
        $data = [
            'servers' => $qm->listOfEnabledServers(['id', 'name']),
            'canExit' => (access_mode_auth() or access_mode_any()) and is_auth(),
            'canEnter' => (access_mode_free() or access_mode_any()) and !is_auth()
        ];

        return view('auth.servers', $data);
    }
}
