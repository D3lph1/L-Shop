<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\AuthHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\NotActivatedException;
use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;

class LoginController extends Controller
{
    public function render(Settings $settings): View
    {
        return view('frontend.auth.login', [
            'isAccessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'isDownForMaintenance' => $settings->get('system.maintenance.enabled')->getValue(DataType::BOOL),
            'isEnabledPasswordReset' => $settings->get('auth.reset_password.enabled')->getValue(DataType::BOOL),
            'isEnabledRegister' => $settings->get('auth.register.enabled')->getValue(DataType::BOOL)
        ]);
    }

    public function handle(LoginRequest $request, AuthHandler $handler, Notificator $notificator)
    {
        try {
            $dto = $handler->handle(
                (string)$request->get('username'),
                (string)$request->get('password'),
                true
            );

            if ($dto->isSuccessfully()) {
                $notificator->notify(new Success(__('msg.frontend.auth.login.welcome', [
                    'username' => $dto->getUser()->getUsername()
                ])));

                return new JsonResponse(Status::SUCCESS);
            }

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Danger(__('msg.frontend.auth.login.invalid_credentials')));

        } catch (NotActivatedException $e) {
            return (new JsonResponse('not_activated'))
                ->addNotification(new Danger(__('msg.frontend.auth.login.not_activated')));
        }
    }
}
