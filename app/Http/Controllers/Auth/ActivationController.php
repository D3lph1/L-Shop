<?php

namespace App\Http\Controllers\Auth;

use App\Services\Activator;
use Cartalyst\Sentinel\Sentinel;
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
     * @param Request  $request
     * @param Sentinel $sentinel
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate(Request $request, Sentinel $sentinel)
    {
        $userId = (int)$request->route('user');

        $user = $sentinel->getUserRepository()->findById($userId);

        if (!$user) {
            $this->msg->danger('Пользователь не найден');

            return response()->redirectToRoute('signin');
        }

        $code = $request->route('code');
        if ($sentinel->getActivationRepository()->complete($user, $code)) {
            $this->msg->success(__('messages.auth.activation.success'));
        } else {
            $this->msg->danger(__('messages.auth.activation.fail'));
        }

        return response()->redirectToRoute('signin');
    }

    /**
     * @param RepeatSendActivationRequest $request
     * @param Sentinel                    $sentinel
     * @param Activator                   $activator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function repeatSend(RepeatSendActivationRequest $request, Sentinel $sentinel, Activator $activator)
    {
        $email = $request->get('email');
        $user = $sentinel->getUserRepository()->findByCredentials(['email' => $email]);

        if (!$user) {
            $this->msg->danger(__('messages.auth.activation.user_not_found'));

            return back();
        }

        if ($sentinel->getActivationRepository()->completed($user)) {
            $this->msg->info('Этот аккаунт уже подтвержден');
        } else {
            $activator->createAndSend($user);
            $this->msg->info(__('messages.auth.activation.repeat'));
        }

        return back();
    }
}
