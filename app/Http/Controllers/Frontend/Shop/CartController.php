<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\DataTransferObjects\Frontend\Shop\Cart\Purchase;
use App\DataTransferObjects\Frontend\Shop\Server;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Server\ServerNotFoundException;
use App\Handlers\Frontend\Shop\Cart\PurchaseHandler;
use App\Handlers\Frontend\Shop\Cart\PutHandler;
use App\Handlers\Frontend\Shop\Cart\RemoveHandler;
use App\Handlers\Frontend\Shop\Cart\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth as AuthMiddleware;
use App\Http\Middleware\Captcha as CaptchaMiddleware;
use App\Http\Requests\Frontend\Shop\Cart\PurchaseRequest;
use App\Http\Requests\Frontend\Shop\Cart\PutRequest;
use App\Http\Requests\Frontend\Shop\Cart\RemoveRequest;
use App\Services\Cart\Cart;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Security\Captcha\Captcha;
use App\Services\Server\Persistence\Persistence;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\auth_middleware;

/**
 * Class CartController
 * Handles requests from the shopping cart page.
 */
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AuthMiddleware::ANY));
        $this->middleware(CaptchaMiddleware::NAME)->only('purchase');
    }

    /**
     * Returns the data to render the cart page.
     *
     * @param Request      $request
     * @param VisitHandler $handler
     * @param Captcha      $captcha
     * @param Persistence  $persistence
     * @param Settings     $settings
     *
     * @return JsonResponse
     */
    public function render(Request $request, VisitHandler $handler, Captcha $captcha, Persistence $persistence, Settings $settings): JsonResponse
    {
        $server = $persistence->retrieve();
        if ($server !== null) {
            $server = new Server($server);
        }

        return new JsonResponse(Status::SUCCESS, [
            'cart' => $handler->handle((int)$request->route('server')),
            'captchaKey' => $settings->get('system.security.captcha.enabled')->getValue(DataType::BOOL) ? $captcha->key() : null,
            'currentServer' => $server
        ]);
    }

    /**
     * Processes a request to add product to the cart.
     *
     * @param PutRequest  $request
     * @param PutHandler  $handler
     * @param Cart        $cart
     * @param Persistence $persistence
     *
     * @return JsonResponse
     */
    public function put(PutRequest $request, PutHandler $handler, Cart $cart, Persistence $persistence): JsonResponse
    {
        $handler->handle($request->get('product'));

        return (new JsonResponse(Status::SUCCESS, [
            'amount' => $persistence->retrieve() ? count($cart->retrieveServer($persistence->retrieve())) : null
        ]))
            ->addNotification(new Success(__('msg.frontend.shop.catalog.put_in_cart')));
    }

    /**
     * Processes a request to remove product from the cart.
     *
     * @param RemoveRequest $request
     * @param RemoveHandler $handler
     *
     * @return JsonResponse
     */
    public function remove(RemoveRequest $request, RemoveHandler $handler): JsonResponse
    {
        try {
            $handler->handle($request->get('product'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.shop.cart.remove.success')));
        } catch (ProductNotFoundException $e) {
            return (new JsonResponse('product_does_not_exist'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Warning(__('msg.frontend.shop.cart.remove.fail')));
        }
    }

    /**
     * Processes a request for the purchase of products that are currently in the cart.
     *
     * @param PurchaseRequest $request
     * @param PurchaseHandler $handler
     *
     * @return JsonResponse
     */
    public function purchase(PurchaseRequest $request, PurchaseHandler $handler): JsonResponse
    {
        try {
            $dto = (new Purchase())
                ->setItems($request->get('items'))
                ->setServerId((int)$request->route('server'))
                ->setUsername($request->get('username'))
                ->setIp($request->ip());

            $result = $handler->handle($dto);

            if ($result->isQuick()) {
                return (new JsonResponse(Status::SUCCESS, [
                    'quick' => true,
                    'newBalance' => $result->getNewBalance()
                ]))
                    ->addNotification(new Success(__('msg.frontend.shop.catalog.purchase.success')));
            } else {
                return new JsonResponse(Status::SUCCESS, [
                    'quick' => false,
                    'purchaseId' => $result->getPurchaseId()
                ]);
            }
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.frontend.shop.cart.purchase.server_not_found')));
        }
    }
}
