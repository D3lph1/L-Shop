<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\DataTransferObjects\Frontend\Shop\Server;
use App\Exceptions\Product\DoesNotExistException;
use App\Handlers\Frontend\Shop\Cart\PutHandler;
use App\Handlers\Frontend\Shop\Cart\RemoveHandler;
use App\Handlers\Frontend\Shop\Cart\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth as AuthMiddleware;
use App\Http\Requests\Frontend\Shop\Cart\PutRequest;
use App\Http\Requests\Frontend\Shop\Cart\RemoveRequest;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use Illuminate\Http\Request;
use function App\auth_middleware;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AuthMiddleware::SOFT));
    }

    public function render(Request $request, VisitHandler $handler, Captcha $captcha, Persistence $persistence)
    {
        $server = $persistence->retrieve();
        if ($server !== null) {
            $server = new Server($server);
        }

        return [
            'cart' => $handler->handle((int)$request->route('server')),
            'captcha' => $captcha->view(),
            'currentServer' => $server
        ];
    }

    public function put(PutRequest $request, PutHandler $handler, Cart $cart, Persistence $persistence): JsonResponse
    {
        $handler->handle($request->get('product'));

        return (new JsonResponse(Status::SUCCESS, [
            'amount' => $persistence->retrieve() ? count($cart->retrieveServer($persistence->retrieve())) : null
        ]))
            ->addNotification(new Success(__('msg.frontend.shop.catalog.put_in_cart')));
    }

    public function remove(RemoveRequest $request, RemoveHandler $handler): JsonResponse
    {
        try {
            $handler->handle($request->get('product'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.shop.cart.remove.success')));
        } catch (DoesNotExistException $e) {
            return (new JsonResponse('product_does_not_exist'))
                ->addNotification(new Warning(__('msg.frontend.shop.cart.remove.fail')));
        }
    }
}
