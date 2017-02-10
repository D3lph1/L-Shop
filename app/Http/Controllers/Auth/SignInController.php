<?php

namespace App\Http\Controllers\Auth;

use App\Services\Message;
use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

class SignInController extends Controller
{
    /**
     * Render the sign in page
     *
     * @param Request $request
     * @return mixed
     */
    public function render(Request $request)
    {
        if (access_mode_free()) {
            return redirect()->route('servers');
        }

        $data = [
            'enable_signup' => is_enable('shop.enable_signup'),
            'enable_pr' => is_enable('shop.enable_password_reset'),
        ];

        return view('auth.signin', $data);
    }

    /**
     * Handle the user signin
     *
     * @param SignInRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signin(SignInRequest $request)
    {
        $credentials = [
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];

        try {
            $auth = \Sentinel::authenticate($credentials, true);
        } catch (ThrottlingException $e) {
            return response()->json([
                'status' => 'frozen',
                'delay' => $e->getDelay()
            ]);
        }

        if ($auth) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json(['status' => 'invalid_credentials']);
    }

    /**
     * Authorizes the user by transmitting him credentials in GET-request
     *
     * @param SignInRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(SignInRequest $request)
    {
        //
    }

    public function logout(Message $msg)
    {
        \Sentinel::logout();

        return response()->redirectToRoute('signin')->withCookie($msg->info('Вы вышли из аккаунта'));
    }
}
