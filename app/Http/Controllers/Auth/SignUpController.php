<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Controllers\Controller;

class SignUpController extends Controller
{
    /**
     * Render the sign up page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        return view('auth.signup');
    }

    public function signup(SignUpRequest $request)
    {
        //
    }
}
