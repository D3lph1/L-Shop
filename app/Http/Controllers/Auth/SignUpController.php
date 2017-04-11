<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\UsernameAlreadyExistsException;
use App\Exceptions\User\EmailAlreadyExistsException;
use App\Exceptions\User\UnableToCreateUser;
use App\Http\Requests\SignUpRequest;
use App\Http\Controllers\Controller;
use Illuminate\Container\Container;
use Illuminate\Http\Request;

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
        if ((bool)s_get('shop.enable_signup')) {
            return view('auth.signup');
        }
        \Message::warning('Функция регистрации отключена');

        return response()->redirectToRoute('servers');
    }

    /**
     * Register new user
     *
     * @param SignUpRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function signup(SignUpRequest $request)
    {
        if (!s_get('shop.enable_signup')) {
            return response()->redirectToRoute('signin');
        }

        $username = $request->get('username');
        $email = $request->get('email');
        $password = $request->get('password');
        $forceActivate = !(bool)s_get('auth.email_activation');

        // Get registrar service from container
        $registrar = Container::getInstance()->make('registrar');

        try {
            // Call registrar service method
            $registrar->register($username, $email, $password, 0, $forceActivate, false);
        } catch (UsernameAlreadyExistsException $e) {
            \Message::danger(trans('validation.unique', ['attribute' => 'Имя пользователя']));

            return back();
        } catch (EmailAlreadyExistsException $e) {
            \Message::danger(trans('validation.email', ['attribute' => 'Адрес электронной почты']));

            return back();
        } catch (UnableToCreateUser $e) {
            \Message::danger(trans('messages.error.signup'));

            return back();
        }

        return $this->redirect(!$forceActivate);
    }

    /**
     * @param bool $activate
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirect($activate)
    {
        if ($activate) {
            return response()->redirectToRoute('activation.wait');
        }else {
            \Message::success('Вы успешно зарегистрированы');

            return response()->redirectToRoute('signin');
        }
    }
}
