<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use App\Services\Activator;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RepeatSendActivationRequest;
use Illuminate\View\View;

/**
 * Class ActivationController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Auth
 */
class ActivationController extends Controller
{
    public function renderWaitPage(): View
    {
        return view('auth.activate_wait');
    }

    public function activate(Request $request, Sentinel $sentinel): RedirectResponse
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

    public function repeatSend(RepeatSendActivationRequest $request, Sentinel $sentinel, Activator $activator): RedirectResponse
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
