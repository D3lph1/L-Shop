<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\InvalidArgumentException;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Auth as AuthService;
use App\Services\Infrastructure\Notification\Notification;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Auth
{
    public const GUEST = 'guest';

    public const SOFT = 'soft';

    public const HARD = 'hard';

    /**
     * @var AuthService
     */
    private $auth;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(AuthService $auth, Settings $settings)
    {
        $this->auth = $auth;
        $this->settings = $settings;
    }

    public function handle(Request $request, \Closure $next, ?string $mode = null)
    {
        if ($mode === null) {
            if ($this->auth->check()) {
                return $next($request);
            }

            return $this->response('frontend.auth.login', new Warning(__('msg.only_for_auth')));
        }

        switch ($mode) {
            case self::GUEST:
                if ($this->auth->check()) {
                    return $this->response('frontend.auth.servers', new Warning(__('msg.only_for_guests')));
                }

                return $next($request);

            case self::SOFT:
                if ($this->settings->get('auth.access_mode')->getValue() === AccessMode::AUTH && !$this->auth->check()) {
                    return $this->response('frontend.auth.login', new Warning(__('msg.only_for_auth')));
                }

                return $next($request);

            case self::HARD:
                if (!$this->auth->check()) {
                    return $this->response('frontend.auth.login', new Warning(__('msg.only_for_auth')));
                }

                return $next($request);

            default:
                throw new InvalidArgumentException(
                    sprintf(
                        '$mode must be has next values: "%s", "%s", "%s", "%s". %s given',
                        self::GUEST,
                        self::SOFT,
                        self::HARD,
                        $mode
                    )
                );
        }
    }

    /**
     * Construct response.
     *
     * @param string       $redirect
     * @param Notification $notification
     *
     * @return Response
     */
    private function response(string $redirect, ?Notification $notification = null)
    {
        $response = (new JsonResponse(Status::FORBIDDEN))->setEarlyRedirect($redirect);
        if (!is_null($notification)) {
            $response->addNotification($notification);
        }

        return new Response($response, 403);
    }
}
