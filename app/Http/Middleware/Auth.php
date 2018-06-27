<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\InvalidArgumentException;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Auth as AuthService;
use App\Services\Notification\Notification;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Router;

class Auth
{
    public const GUEST = 'guest';

    public const AUTH = 'auth';

    public const ANY = 'any';

    protected $except = [
        'frontend.auth.login.render',
        'frontend.auth.login.handle'
    ];

    /**
     * @var AuthService
     */
    private $auth;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Router
     */
    private $router;

    public function __construct(AuthService $auth, Settings $settings, Router $router)
    {
        $this->auth = $auth;
        $this->settings = $settings;
        $this->router = $router;
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

                if ($this->settings->get('auth.access_mode')->getValue() === AccessMode::GUEST) {
                    $f = false;
                    foreach ($this->except as $except) {
                        if ($except === $this->router->currentRouteName()) {
                            $f = true;
                            break;
                        }
                    }

                    if (!$f) {
                        return $this->response('frontend.auth.servers', new Warning(__('msg.forbidden')));
                    }
                }

                return $next($request);

            case self::AUTH:
                if (!$this->auth->check()) {
                    return $this->response('frontend.auth.login', new Warning(__('msg.only_for_auth')));
                }

                return $next($request);

            case self::ANY:
                if ($this->settings->get('auth.access_mode')->getValue() === AccessMode::AUTH && !$this->auth->check()) {
                    return $this->response('frontend.auth.login', new Warning(__('msg.only_for_auth')));
                }

                return $next($request);

            default:
                throw new InvalidArgumentException(
                    sprintf(
                        '$mode must be has next values: "%s", "%s", "%s", "%s". %s given',
                        self::GUEST,
                        self::ANY,
                        self::AUTH,
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
