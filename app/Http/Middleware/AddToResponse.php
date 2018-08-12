<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use App\Services\Auth\Auth;
use App\Services\Auth\Exceptions\BannedException;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notificator;
use App\Services\Response\JsonResponse;
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
                $httpStatus = $response->getStatusCode();
                if (isset($json['httpStatus'])) {
                    $httpStatus = $json['httpStatus'];
                    // Remove element 'http_status' from resulting content.
                    unset($json['httpStatus']);
                }
                if (isset($json['notifications'])) {
                    // Add notifications to response.
                    foreach ($this->notificator->pull() as $item) {
                        $json['notifications'][] = $item;
                    }
                }
                try {
                    if ($this->auth->check() && $response->status() !== 500) {
                        // Add information about user authentication status.
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

                    $response
                        ->setStatusCode($httpStatus)
                        ->setContent(json_encode($json));
                } catch (BannedException $e) {
                    $this->auth->logout();

                    // Creating user ban notification.
                    $banMessages = $this->banMessage->buildMessageAuto($e->getBans());
                    if (count($banMessages->getMessages()) === 0) {
                        // Return response with ban notifications without points.
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
