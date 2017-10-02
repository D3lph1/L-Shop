<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Traits\Validator;
use App\TransactionScripts\Authentication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SignupController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Api
 */
class SignupController extends ApiController
{
    use Validator;

    /**
     * Signup user by API.
     */
    public function signup(Request $request, Authentication $script): JsonResponse
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

        if (!$this->validateUsername($username)) {
            return json_response('invalid username', ['code' => 4]);
        }

        if (!$this->validateHash($hash, $username, $email, $password, $balance, $forceActivate, $admin)) {
            return $this->invalidHashResponse();
        }

        try {
            // Register new user.
            $script->register($username, $email, $password, (float)$balance, (bool)$forceActivate, (bool)$admin);
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
