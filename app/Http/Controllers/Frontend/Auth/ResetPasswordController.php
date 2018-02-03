<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ResetPasswordHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ResetPasswordRequest;
use App\Services\Auth\AccessMode;
use App\Services\Infrastructure\Notification\Notifications\Danger;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    public function render(Request $request, ResetPasswordHandler $handler, Notificator $notificator, Settings $settings)
    {
        $code = $request->route('code');
        if (!$handler->isValidCode($code)) {
            $notificator->notify(new Danger(__('msg.frontend.auth.reset.invalid_code')));

            return redirect()->route('frontend.auth.login.render');
        }

        return view('frontend.auth.reset_password', [
            'isAccessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'isAccessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'code' => $code
        ]);
    }

    public function handle(ResetPasswordRequest $request, ResetPasswordHandler $handler, Notificator $notificator)
    {
        $result = $handler->handle((string)$request->route('code'), (string)$request->get('password'));
        if ($result) {
            $notificator->notify(new Success(__('msg.frontend.auth.reset.success')));

            return new JsonResponse(Status::SUCCESS, [
                'redirect' => route('frontend.auth.login.render')
            ]);
        }

        return (new JsonResponse(Status::FAILURE))
            ->addNotification(new Danger(__('msg.frontend.auth.reset.fail')));
    }
}
