<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\ForgotPasswordHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Captcha as CaptchaMiddleware;
use App\Http\Requests\Frontend\Auth\ForgotPasswordRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Security\Captcha\Captcha;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Http\Response;

/**
 * Class ForgotPasswordController
 * Handles requests related to forgot user password actions.
 */
class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware(CaptchaMiddleware::NAME)->only('handle');
    }

    /**
     * Returns the data needed to render the page with the request form for password recovery.
     *
     * @param Settings $settings
     * @param Captcha  $captcha
     *
     * @return JsonResponse
     */
    public function render(Settings $settings, Captcha $captcha): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, [
            'accessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'accessModeAuth' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'captchaKey' => $settings->get('system.security.captcha.enabled')->getValue(DataType::BOOL) ? $captcha->key() : null
        ]);
    }

    /**
     * Processes the request for password recovery.
     *
     * @param ForgotPasswordRequest $request
     * @param ForgotPasswordHandler $handler
     *
     * @return JsonResponse
     */
    public function handle(ForgotPasswordRequest $request, ForgotPasswordHandler $handler): JsonResponse
    {
        try {
            $handler->handle($request->get('email'));

            return (new JsonResponse(Status::SUCCESS, [
                'redirect' => 'frontend.auth.login'
            ]))->addNotification(new Success(__('msg.frontend.auth.password.forgot.success')));
        } catch (UserDoesNotExistException $e) {
            return (new JsonResponse('user_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.frontend.auth.password.forgot.user_not_found')));
        }
    }
}
