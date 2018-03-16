<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Auth\Exceptions\BannedException;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notificator;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Support\Lang\Ban\BanMessage;
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

    /**
     * @var BanMessage
     */
    private $banMessage;

    public function __construct(Auth $auth, Notificator $notificator, BanMessage $banMessage)
    {
        $this->auth = $auth;
        $this->notificator = $notificator;
        $this->banMessage = $banMessage;
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
                try {
                    if ($this->auth->check() && $response->status() !== 500) {
                        if (isset($json['auth'])) {
                            $json['auth'] = array_merge($json['auth'], [
                                'username' => $this->auth->getUser()->getUsername()
                            ]);
                        } else {
                            $json['auth'] = [
                                'username' => $this->auth->getUser()->getUsername()
                            ];
                        }
                    }
                    $response->setContent(json_encode($json));
                } catch (BannedException $e) {
                    $this->auth->logout();

                    $banMessages = $this->banMessage->buildMessageAuto($e->getBans());
                    if (count($banMessages->getMessages()) === 0) {
                        return response()->json((new JsonResponse('banned', [
                            'early_redirect' => 'frontend.auth.login'
                        ]))
                            ->addNotification(new Error($banMessages->getTitle())), 403);
                    }

                    $notification = $banMessages->getTitle();
                    $i = 1;
                    foreach ($banMessages->getMessages() as $message) {
                        $notification .= "<br>{$i}) {$message}";
                        $i++;
                    }

                    return response()->json((new JsonResponse('banned', [
                        'early_redirect' => 'frontend.auth.login'
                    ]))
                        ->addNotification(new Error($notification)), 403);
                }
            }
        }

        return $response;
    }
}
