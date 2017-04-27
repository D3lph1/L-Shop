<?php

namespace App\Http\Controllers\Auth;

use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\RemindCodeNotFound;
use App\Exceptions\User\UnableToCompleteRemindException;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ForgotPasswordController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /**
     * @var Reminder
     */
    private $reminder;

    /**
     * @param Reminder $reminder
     */
    public function __construct(Reminder $reminder)
    {
        $this->reminder = $reminder;
        parent::__construct();
    }

    /**
     * Render forgot password page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        return view('auth.forgot');
    }

    /**
     * Handle forgot password request
     *
     * @param ForgotPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(ForgotPasswordRequest $request)
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }
        $email = $request->get('email');

        try {
            $this->reminder->forgot($email, $request->ip());
        } catch (NotFoundException $e) {
            \Message::danger('Пользователь с таким адресом электронной почты не найден!');

            return back();
        }
        \Message::info('На вашу почту отправлено письмо с инструкциями по сбросу пароля');

        return back();
    }

    /**
     * Render reset password page
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function renderResetPasswordPage(Request $request)
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        $user = (int)$request->route('user');
        $code = $request->route('code');

        if (!$this->reminder->checkCode($user, $code)) {
            \Message::danger('Код сброса пароля не существует или истек срок восстановления пароля');

            return response()->redirectToRoute('index');
        }

        $data = [
            'user' => $user,
            'code' => $code
        ];

        return view('auth.reset_password', $data);
    }

    /**
     * Handle reset password request
     *
     * @param ResetPasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        if ($this->isDisabled()) {
            return response()->redirectToRoute('index');
        }

        $userId = (int)$request->route('user');
        $code = $request->route('code');
        $password = $request->get('password');

        try {
            $this->reminder->reset($userId, $code, $password);
        } catch (RemindCodeNotFound $e) {
            \Message::danger('Код сброса пароля не существует или истек срок восстановления пароля');

            return response()->redirectToRoute('index');
        } catch (UnableToCompleteRemindException $e) {
            \Log::error($e);
            \Message::danger('Не удалось сменить пароль');

            return response()->redirectToRoute('index');
        }

        \Message::success('Пароль изменен успешно');

        return response()->redirectToRoute('signin');
    }

    /**
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    private function isDisabled()
    {
        if (!s_get('shop.enable_password_reset')) {
            \Message::warning('Администрация проекта отключила возможность восстановления пароля');

            return true;
        }

        return false;
    }
}
