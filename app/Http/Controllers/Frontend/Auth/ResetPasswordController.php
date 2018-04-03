<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ResetPasswordHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetPasswordRequest;
use App\Services\Auth\AccessMode;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function render(Request $request, ResetPasswordHandler $handler, Settings $settings)
    {
        if (!$handler->isValidCode($request->route('code'))) {
            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.frontend.auth.password.reset.invalid_code')));
        }

        return new JsonResponse(Status::SUCCESS, [
            'accessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'accessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY
        ]);
    }

    public function handle(ResetPasswordRequest $request, ResetPasswordHandler $handler, Notificator $notificator)
    {
        $result = $handler->handle((string)$request->route('code'), (string)$request->get('password'));
        if ($result) {
            return (new JsonResponse(Status::SUCCESS, [
                'redirect' => route('frontend.auth.login.render')
            ]))->addNotification(new Success(__('msg.frontend.auth.password.reset.success')));
        }

        return (new JsonResponse(Status::FAILURE))
            ->addNotification(new Error(__('msg.frontend.auth.reset.fail')));
    }
}
