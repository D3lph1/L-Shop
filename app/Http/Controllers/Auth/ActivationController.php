<?php

namespace App\Http\Controllers\Auth;

use App\Services\Activator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RepeatSendActivationRequest;

/**
 * Class ActivationController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Auth
 */
class ActivationController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function renderWaitPage(Request $request)
    {
        return view('auth.activate_wait');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request)
    {
        $userId = (int)$request->route('user');

        $user = \Sentinel::findById($userId);

        if (!$user) {
            \Message::danger('Пользователь не найден');

            return response()->redirectToRoute('signin');
        }

        $code = $request->route('code');
        if (\Activation::complete($user, $code)) {
            \Message::success('Ваш аккаунт успешно активирован!');
        } else {
            \Message::danger('Код активации недействителен или устарел');
        }

        return response()->redirectToRoute('signin');
    }

    /**
     * @param RepeatSendActivationRequest $request
     * @param Activator                   $activator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function repeatSend(RepeatSendActivationRequest $request, Activator $activator)
    {
        $email = $request->get('email');
        $user = \Sentinel::findByCredentials(['email' => $email]);

        if (!$user) {
            \Message::danger('Пользователь с таким адресом электронной почты не найден');

            return back();
        }

        if (\Activation::completed($user)) {
            \Message::info('Этот аккаунт уже подтвержден');
        } else {
            $activator->createAndSend($user);

            \Message::info('Сообщение на почту отправлено повторно');
        }

        return back();
    }
}
