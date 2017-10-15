<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Services\Registrator;
use App\TransactionScripts\Authentication;
use Illuminate\Http\RedirectResponse;

/**
 * Class SignUpController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Auth
 */
class SignUpController extends Controller
{
    /**
     * Render the sign up page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if ((bool)s_get('shop.enable_signup')) {
            return view('auth.signup');
        }
        $this->msg->warning(__('messages.auth.signup.disabled'));

        return response()->redirectToRoute('servers');
    }

    /**
     * Register new user.
     */
    public function signup(SignUpRequest $request, Authentication $script): RedirectResponse
    {
        if (!s_get('shop.enable_signup')) {
            return response()->redirectToRoute('signin');
        }

        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $forceActivate = !(bool)s_get('auth.email_activation');

        try {
            // Call registrar service method.
            $script->register($username, $email, $password, 0, $forceActivate, false);
        } catch (UsernameAlreadyExistsException $e) {

            $this->msg->danger(__('messages.auth.signup.username_already_exists', ['username' => $username]));

            return back();

        } catch (EmailAlreadyExistsException $e) {

            $this->msg->danger(__('messages.auth.signup.email_already_exists', ['email' => $email]));

            return back();

        } catch (UnableToCreateUser $e) {

            $this->msg->danger(__('messages.auth.signup.fail'));

            return back();

        }

        return $this->redirect(!$forceActivate);
    }

    private function redirect(bool $activate): RedirectResponse
    {
        if (s_get('auth.signup.redirect')) {
            return response()->redirectTo(s_get('auth.signup.redirect_url'));
        }

        if ($activate) {
            return response()->redirectToRoute('activation.wait');
        }else {
            $this->msg->success(__('messages.auth.signup.success'));

            return response()->redirectToRoute('signin');
        }
    }
}
