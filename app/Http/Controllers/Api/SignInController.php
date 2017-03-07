<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SignInController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Api
 */
class SignInController extends Controller
{
    /**
     * Authenticate user by request to API
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signin(Request $request)
    {
        if (is_auth()) {
            return $this->redirectToServers();
        }

        // From request
        $username = $request->get('username');
        $hash = $request->get('hash');

        // If request params is empty
        if (!$username or !$hash) {
            return $this->redirectToSignin();
        }

        // From settings
        $secretKey = s_get('api.key');
        $algo = s_get('api.algo');
        $separator = s_get('api.separator');

        $calculatedHash = hash($algo, $secretKey . $separator . $username);
        if ($hash !== $calculatedHash) {
            return $this->redirectToSignin();
        }

        $user = \Sentinel::getUserRepository()->findByCredentials([
            'username' => $username
        ]);

        // If user with given username not found
        if (!$user) {
            return $this->redirectToSignin();
        }

        if (\Sentinel::authenticate($user, (bool)s_get('api.signin.remember_user'))) {
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
