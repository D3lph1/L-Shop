<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\BannedException;
use App\Services\Message;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Illuminate\Http\Request;
use App\Http\Requests\SignInRequest;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;

/**
 * Class SignInController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Auth
 */
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
        $data = [
            'onlyForAdmins' => $request->get('onlyForAdmins'),
            'downForMaintenance' => $this->app->isDownForMaintenance(),
            'enable_signup' => is_enable('shop.enable_signup'),
            'enablePasswordReset' => is_enable('shop.enable_password_reset'),
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
            $user = \Sentinel::authenticate($credentials, true);
        } catch (ThrottlingException $e) {
            return json_response('frozen', [
                'delay' => $e->getDelay()
            ]);
        } catch (NotActivatedException $e) {
            return json_response('not activated');
        } catch (BannedException $e) {
            return json_response('banned', [
                'message' => build_ban_message($e->getUntil(), $e->getReason())
            ]);
        }

        if ($user) {
            if ($request->get('onlyForAdmins') and !$user->hasAccess(['user.admin'])) {
                // If is not admin
                return response()->json([
                    'status' => 'only for admins'
                ]);
            }
            \Message::success("Добро пожаловать, $credentials[username]!");

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

    public function logout()
    {
        \Sentinel::logout();
        \Message::info('Вы вышли из аккаунта');

        return response()->redirectToRoute('signin');
    }
}
