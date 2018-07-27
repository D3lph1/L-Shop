<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\RegisterHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth as AuthMiddleware;
use App\Http\Middleware\Captcha as CaptchaMiddleware;
use App\Http\Requests\Frontend\Auth\RegisterRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\EmailAlreadyExistsException;
use App\Services\Auth\Exceptions\UsernameAlreadyExistsException;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Security\Captcha\Captcha;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Http\Response;
use function App\auth_middleware;

/**
 * Class RegisterController
 * Handles requests related to user registration.
 */
class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AuthMiddleware::GUEST));
        $this->middleware(CaptchaMiddleware::NAME)->only('handle');
    }

    /**
     * Returns the data needed to render the page with the registration form.
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
     * Handles a user register request.
     *
     * @param RegisterRequest $request
     * @param RegisterHandler $handler
     * @param Settings        $settings
     *
     * @return JsonResponse
     */
    public function handle(
        RegisterRequest $request,
        RegisterHandler $handler,
        Settings $settings): JsonResponse
    {
        try {
            $dto = $handler->handle(
                (string)$request->get('username'),
                (string)$request->get('email'),
                (string)$request->get('password')
            );

            if ($dto->isSuccessfully()) {
                if ($dto->isActivated()) {
                    if ($settings->get('auth.register.custom_redirect.enabled')->getValue(DataType::BOOL)) {
                        // Redirect user on custom url after success registration.
                        $data = ['redirectUrl' => $settings->get('auth.register.custom_redirect.url')->getValue()];
                    } else {
                        $data = ['redirect' => 'frontend.auth.servers'];
                    }

                    return (new JsonResponse(Status::SUCCESS, $data))
                        ->addNotification(new Success(__('msg.frontend.auth.register.success')));
                }

                return new JsonResponse(Status::SUCCESS, [
                    'redirect' => 'frontend.auth.activation.sent'
                ]);
            }

            return (new JsonResponse(Status::FAILURE))
                ->addNotification(new Error(__('msg.auth.register.fail')));

        } catch (UsernameAlreadyExistsException $e) {
            return (new JsonResponse('username_already_exists'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Error(__('msg.frontend.auth.register.username_already_exist')));
        } catch (EmailAlreadyExistsException $e) {
            return (new JsonResponse('email_already_exists'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Error(__('msg.frontend.auth.register.email_already_exist')));
        }
    }
}
