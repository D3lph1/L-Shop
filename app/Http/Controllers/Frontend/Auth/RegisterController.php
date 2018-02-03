<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\RegisterHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;

class RegisterController extends Controller
{
    public function render(Settings $settings, Captcha $captcha): View
    {
        return view('frontend.auth.register', [
            'isAccessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'isAccessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'captcha' => $captcha->view()
        ]);
    }

    public function handle(
        RegisterRequest $request,
        RegisterHandler $handler,
        Notificator $notificator): JsonResponse
    {
        try {
            $dto = $handler->handle(
                (string)$request->get('username'),
                (string)$request->get('email'),
                (string)$request->get('password')
            );

            if ($dto->isSuccessfully()) {
                if ($dto->isActivated()) {
                    $notificator->notify(new Success(
                        __('frontend/msg.auth.register.success', [
                            'username' => $dto->getUser()->getUsername()
                        ])
                    ));

                    return new JsonResponse(Status::SUCCESS, [
                        'redirect' => route('frontend.servers')
                    ]);
                }

                return new JsonResponse(Status::SUCCESS, [
                    'redirect' => route('frontend.auth.activation.sent')
                ]);
            }

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Danger(__('msg.auth.register.fail')));

        } catch (UsernameAlreadyExistsException $e) {
            return (new JsonResponse('username_already_exists'))
                ->addNotification(new Danger(__('msg.auth.register.username_already_exists')));
        } catch (EmailAlreadyExistsException $e) {
            return (new JsonResponse('email_already_exists'))
                ->addNotification(new Danger(__('msg.auth.register.email_already_exists')));
        }
    }
}
