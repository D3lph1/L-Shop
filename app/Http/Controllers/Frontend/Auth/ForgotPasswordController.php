<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ForgotPasswordHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ForgotPasswordRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;

class ForgotPasswordController extends Controller
{
    public function render(Settings $settings, Captcha $captcha): View
    {
        return view('frontend.auth.forgot_password', [
            'isAccessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'isAccessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'captcha' => $captcha->view()
        ]);
    }

    public function handle(
        ForgotPasswordRequest $request,
        ForgotPasswordHandler $handler,
        Notificator $notificator): JsonResponse
    {
        try {
            $handler->handle($request->get('email'));
            $notificator->notify(new Success(__('msg.frontend.auth.forgot.success')));

            return (new JsonResponse(Status::SUCCESS, [
                'redirect' => route('frontend.auth.login.render')
            ]));
        } catch (UserDoesNotExistException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Danger(__('msg.frontend.auth.forgot.user_not_found')));
        }
    }
}
