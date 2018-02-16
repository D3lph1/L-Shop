<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddToResponse
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Notificator
     */
    private $notificator;
    
    public function __construct(Auth $auth, Notificator $notificator)
    {
        $this->auth = $auth;
        $this->notificator = $notificator;
    }

    public function handle(Request $request, \Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);
        if (!method_exists($response, 'render')) {
            if (
                $response->headers->has('Content-Type') &&
                $response->headers->get('Content-Type') === 'application/json') {
                $json = json_decode($response->getContent(), true);
                if (isset($json['notifications'])) {
                    foreach ($this->notificator->pull() as $item) {
                        $json['notifications'][] = $item;
                    }
                }
                if ($this->auth->check()) {
                    $json['auth'] = [
                        'username' => $this->auth->getUser()->getUsername()
                    ];
                }
                $response->setContent(json_encode($json));
            }
        }

        return $response;
    }
}
