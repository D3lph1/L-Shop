<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\BannedException;
use App\Http\Controllers\Controller;
use App\TransactionScripts\Authentication;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SignInController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Auth
 */
class SignInController extends Controller
{
    /**
     * Render the sign in page
     */
    public function render(Request $request): View
    {
        return view('auth.signin', [
            'onlyForAdmins' => $request->get('onlyForAdmins'),
            'downForMaintenance' => $this->app->isDownForMaintenance(),
            'enable_signup' => is_enable('shop.enable_signup'),
            'enablePasswordReset' => is_enable('shop.enable_password_reset'),
        ]);
    }

    /**
     * Handle the user signin
     */
    public function signin(Request $request, Authentication $script): JsonResponse
    {
        try {
            $user = $script->authenticate($request->get('username'), $request->get('password'));
        } catch (ThrottlingException $e) {
            return json_response('frozen', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.auth.signin.frozen', ['delay' => $e->getDelay()])
                ]
            ]);
        } catch (NotActivatedException $e) {
            return json_response('not activated', [
                'message' => [
                    'type' => 'danger',
                    'text' => __('messages.auth.signin.not_activated')
                ]
            ]);
        } catch (BannedException $e) {
            return json_response('banned', [
                'message' => [
                    'type' => 'danger',
                    'text' => build_ban_message($e->getUntil(), $e->getReason())
                ]
            ]);
        }

        if (!is_null($user)) {
            if ($request->get('onlyForAdmins') and !is_admin()) {
                // If is not admin.
                return json_response('only_for_admins', [
                    'message' => [
                        'type' => 'danger',
                        'text' => __('messages.auth.signin.only_for_admins')
                    ]
                ]);
            }
            $this->msg->success(__('messages.auth.signin.welcome', ['username' => $user->getUsername()]));

            return json_response('success');
        }

        return json_response('invalid_credentials', [
            'message' => [
                'type' => 'danger',
                'text' => __('messages.auth.signin.invalid_credentials')
            ]
        ]);
    }

    /**
     * Logout current user.
     */
    public function logout(): RedirectResponse
    {
        $this->sentinel->logout();
        $this->msg->info(__('messages.auth.logout'));

        return response()->redirectToRoute('signin');
    }
}
