<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Auth;

use App\Handlers\Frontend\Auth\LoginHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\LoginRequest;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Exceptions\BannedException;
use App\Services\Auth\Exceptions\NotActivatedException;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notificator;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use App\Services\Support\Lang\Ban\BanMessage;
use Illuminate\Http\Response;

/**
 * Class LoginController
 * Handles requests related to user authentication.
 */
class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Returns the data needed to render the page with the authorization form.
     *
     * @param Settings $settings
     *
     * @return JsonResponse
     */
    public function render(Settings $settings)
    {
        return new JsonResponse(Status::SUCCESS, [
            // TODO: only for admins ???
            'onlyForAdmins' => false,
            'accessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'downForMaintenance' => $settings->get('system.maintenance.enabled')->getValue(DataType::BOOL),
            'enabledPasswordReset' => $settings->get('auth.reset_password.enabled')->getValue(DataType::BOOL),
            'enabledRegister' => $settings->get('auth.register.enabled')->getValue(DataType::BOOL)
        ]);
    }

    /**
     * Handles a user authentication request.
     *
     * @param LoginRequest $request
     * @param LoginHandler $handler
     * @param Notificator  $notificator
     * @param BanMessage   $banMessage
     *
     * @return JsonResponse
     */
    public function handle(LoginRequest $request, LoginHandler $handler, Notificator $notificator, BanMessage $banMessage)
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

            return (new JsonResponse('user_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.frontend.auth.login.invalid_credentials')));

        } catch (NotActivatedException $e) {
            return (new JsonResponse('user_not_activated'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Error(__('msg.frontend.auth.login.not_activated')));
        } catch (BannedException $e) {
            $banMessages = $banMessage->buildMessageAuto($e->getBans());
            if (count($banMessages->getMessages()) === 0) {
                return (new JsonResponse('banned'))
                    ->setHttpStatus(Response::HTTP_CONFLICT)
                    ->addNotification(new Error($banMessages->getTitle()));
            }

            $notification = $banMessages->getTitle();
            $i = 1;
            foreach ($banMessages->getMessages() as $message) {
                $notification .= "<br>{$i}) {$message}";
                $i++;
            }

            return (new JsonResponse('banned'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Error($notification));
        }
    }
}
