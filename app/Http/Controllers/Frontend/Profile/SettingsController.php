<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Handlers\Frontend\Profile\Character\ChangePasswordHandler;
use App\Handlers\Frontend\Profile\Character\ResetSessionsHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Profile\Character\ChangePasswordRequest;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function password(ChangePasswordRequest $request, ChangePasswordHandler $handler): JsonResponse
    {
        $password = $request->get('password');
        $handler->handle($password);

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.frontend.profile.settings.password_change.success')));
    }

    public function resetSessions(ResetSessionsHandler $handler): JsonResponse
    {
        $handler->handle();

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Info(__('msg.frontend.profile.settings.reset_sessions.success')));
    }
}
