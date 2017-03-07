<?php

namespace App\Http\Controllers\Auth;

use App\Services\Activator;
use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Controllers\Controller;

/**
 * Class SignUpController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Auth
 */
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

    /**
     * @param SignUpRequest $request
     * @param Activator     $activator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signup(SignUpRequest $request, Activator $activator)
    {
        $credentials = [
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        $activate = (bool)s_get('auth.email_activation');
        $user = \Sentinel::register($credentials, !$activate);

        if (!$user) {
            \Message::danger('Не удалось зарегистрировать пользователя');

            return back();
        }

        if ($activate) {
            // create new activation and send email
            $activator->createAndSend($user);
            return response()->redirectToRoute('activation.wait');
        }else {
            \Message::success('Вы успешно зарегистрированы');

            return response()->redirectToRoute('signin');
        }
    }
}
