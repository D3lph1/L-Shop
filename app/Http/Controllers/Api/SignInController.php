<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\User\BannedException;
use Illuminate\Http\Request;

/**
 * Class SignInController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Api
 */
class SignInController extends ApiController
{
    /**
     * Authenticate user by request to API.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signin(Request $request)
    {
        if (is_auth() or !$this->isEnabled('signin')) {
            return $this->redirectToSignin();
        }

        // From request
        $username = $request->get('username');
        $hash = $request->get('hash');

        // If request params is empty
        if (!$username or !$hash) {
            return $this->redirectToSignin();
        }

        if (!$this->validateHash($hash, $username)) {
            return $this->redirectToSignin();
        }

        $user = $this->sentinel->getUserRepository()->findByCredentials([
            'username' => $username
        ]);

        // If user with given username not found
        if (!$user) {
            return $this->redirectToSignin();
        }

        if (access_mode_guest() and !$user->hasAccess(['user.admin'])) {
            return $this->redirectToServers();
        }

        try {
            if ($this->sentinel->authenticate($user, (bool)s_get('api.signin.remember_user'))) {
                $this->msg->success(__('messages.auth.signin.welcome', ['username' => $username]));

                return $this->redirectToServers();
            }
        } catch (BannedException $e) {
            $this->msg->danger(build_ban_message($e->getUntil(), $e->getReason()));

            return $this->redirectToServers();
        }

        return $this->redirectToSignin();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToServers()
    {
        return response()->redirectToRoute('servers');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectToSignin()
    {
        return response()->redirectTo('signin');
    }
}
