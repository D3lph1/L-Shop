<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\BannedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class SignInController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Auth
 */
class SignInController extends Controller
{
    /**
     * Render the sign in page
     */
    public function render(Request $request): View
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
     */
    public function signin(SignInRequest $request): JsonResponse
    {
        $credentials = [
            'username' => $request->get('username'),
            'password' => $request->get('password')
        ];

        try {
            $user = \Sentinel::authenticate($credentials, true);
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

        if ($user) {
            if ($request->get('onlyForAdmins') and !$user->hasAccess(['user.admin'])) {
                // If is not admin.
                return json_response('only_for_admins', [
                    'message' => [
                        'type' => 'danger',
                        'text' => __('messages.auth.signin.only_for_admins')
                    ]
                ]);
            }
            $this->msg->success(__('messages.auth.signin.welcome', ['username' => $user->getUserLogin()]));

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
    public function logout(Sentinel $sentinel): RedirectResponse
    {
        $sentinel->logout();
        $this->msg->info(__('messages.auth.logout'));

        return response()->redirectToRoute('signin');
    }
}
