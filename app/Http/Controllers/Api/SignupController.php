<?php

namespace App\Http\Controllers\Api;

use App\Services\Registrar;
use Illuminate\Http\Request;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UsernameAlreadyExistsException;

/**
 * Class SignupController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Api
 */
class SignupController extends ApiController
{
    /**
     * Signup user by API.
     *
     * @param Request   $request
     * @param Registrar $registrar
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(Request $request, Registrar $registrar)
    {
        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $balance = $request->get('balance');
        $forceActivate = $request->get('force_activate');
        $admin = $request->get('admin');
        $hash = $request->get('hash');

        if (!$this->isEnabled('signup')) {
            return $this->optionDisabledResponse();
        }

        if (!$this->validateHash($hash, $username, $email, $password, $balance, $forceActivate, $admin)) {
            return $this->invalidHashResponse();
        }

        try {
            // Register new user.
            $registrar->register($username, $email, $password, $balance, (bool)$forceActivate, $admin);
        } catch (UsernameAlreadyExistsException $e) {
            return json_response('username already exists', ['code' => 1]);
        } catch (EmailAlreadyExistsException $e) {
            return json_response('email already exists', ['code' => 2]);
        } catch (UnableToCreateUser $e) {
            return json_response('unable to create user', ['code' => 3]);
        }

        return json_response('success', ['code' => 0]);
    }
}
