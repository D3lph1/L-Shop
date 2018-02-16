<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\CompleteActivationHandler;
use App\Handlers\Frontend\Auth\RepeatActivationHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\RepeatActivationRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\AlreadyActivatedException;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ActivationController extends Controller
{
    public function sent(Settings $settings, Captcha $captcha)
    {
        return new JsonResponse(Status::SUCCESS, [
            'accessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'accessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'captcha' => $captcha->view()
        ]);
    }

    public function repeat(RepeatActivationRequest $request, RepeatActivationHandler $handler): JsonResponse
    {
        try {
            $handler->handle($request->get('email'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.frontend.auth.activation.repeat')));
        } catch (UserDoesNotExistException $e) {
            return (new JsonResponse('user_not_found'))
                ->addNotification(new Error(__('msg.frontend.auth.activation.user_not_found')));
        } catch (AlreadyActivatedException $e) {
            return (new JsonResponse('already_activated'))
                ->addNotification(new Error(__('msg.frontend.auth.activation.already')));
        }
    }

    public function complete(Request $request, CompleteActivationHandler $handler, Notificator $notificator): RedirectResponse
    {
        if ($handler->handle($request->route('code'))) {
            $notificator->notify(new Success(__('msg.frontend.auth.activation.success')));
        } else {
            $notificator->notify(new Error(__('msg.frontend.auth.activation.fail')));
        }

        return redirect()->to('/login');
    }
}
