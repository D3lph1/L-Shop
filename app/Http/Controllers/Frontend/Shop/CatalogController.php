<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use function App\auth_middleware;
use App\DataTransferObjects\Frontend\Shop\Server;
use App\Exceptions\Category\CategoryNotFoundException as CategoryDoesNotExistException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Server\ServerNotFoundException as ServerDoesNotExistException;
use App\Handlers\Frontend\Shop\Catalog\PurchaseHandler;
use App\Handlers\Frontend\Shop\Catalog\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth as AuthMiddleware;
use App\Http\Requests\Frontend\Shop\Catalog\PurchaseRequest;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AuthMiddleware::SOFT));
    }

    public function render(
        Request $request,
        VisitHandler $handler,
        Settings $settings,
        Cart $cart,
        Captcha $captcha,
        Auth $auth,
        Persistence $persistence)
    {
        try {
            $dto = $handler->handle((int)$request->route('server'), (int)$request->route('category'));
        } catch (ServerDoesNotExistException $e) {
            throw new NotFoundHttpException();
        } catch (CategoryDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }

        $server = $persistence->retrieve();
        if ($server !== null) {
            $server = new Server($server);
        }

        $productsCrudAccess = $auth->check() ? $auth->getUser()->hasPermission(Permissions::ADMIN_PRODUCTS_CRUD_ACCESS) : false;
        $itemsCrudAccess = $auth->check() ? $auth->getUser()->hasPermission(Permissions::ADMIN_ITEMS_CRUD_ACCESS) : false;

        return new JsonResponse(Status::SUCCESS, [
            'shopName' => $settings->get('shop.name')->getValue(),
            'currency' => $settings->get('shop.currency.html')->getValue(),
            'logo' => asset('/img/layout/logo/small.png'),
            'server' => $dto->getServer(),
            'currentCategory' => $dto->getCurrentCategory(),
            'paginator' => $dto->getPaginator(),
            'products' => $dto->getProducts(),
            'cart' => $cart,
            'captcha' => $captcha->view(),
            'currentServer' => $server,
            'productsCrudAccess' => $productsCrudAccess,
            'itemsCrudAccess' => $itemsCrudAccess
        ]);
    }

    public function purchase(PurchaseRequest $request, PurchaseHandler $handler): JsonResponse
    {
        try {
            $result = $handler->handle(
                (int)$request->get('product'),
                abs((int)$request->get('amount')),
                $request->get('username'),
                $request->ip()
            );

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
        } catch (ProductNotFoundException $e) {
            return (new JsonResponse('product_not_found'))
                ->addNotification(new Error(__('msg.frontend.shop.catalog.product_not_found')));
        }
    }
}
