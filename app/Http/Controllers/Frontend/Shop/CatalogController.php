<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\DataTransferObjects\Frontend\Shop\Server;
use App\Exceptions\Category\CategoryNotFoundException as CategoryDoesNotExistException;
use App\Exceptions\Distributor\DistributionException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Exceptions\Purchase\InvalidAmountException;
use App\Exceptions\Server\ServerNotFoundException as ServerDoesNotExistException;
use App\Handlers\Frontend\Shop\Catalog\PurchaseHandler;
use App\Handlers\Frontend\Shop\Catalog\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Auth as AuthMiddleware;
use App\Http\Middleware\Captcha as CaptchaMiddleware;
use App\Http\Requests\Frontend\Shop\Catalog\PurchaseRequest;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use App\Services\Cart\Cart;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Security\Captcha\Captcha;
use App\Services\Server\Persistence\Persistence;
use App\Services\Server\ServerAccess;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\auth_middleware;

/**
 * Class CatalogController
 * Handles requests from the catalog page.
 */
class CatalogController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AuthMiddleware::ANY));
        $this->middleware(CaptchaMiddleware::NAME)->only('purchase');
    }

    /**
     * Returns the data to render the catalog page.
     *
     * @param Request      $request
     * @param RenderHandler $handler
     * @param Settings     $settings
     * @param Cart         $cart
     * @param Captcha      $captcha
     * @param Auth         $auth
     * @param Persistence  $persistence
     *
     * @return JsonResponse
     */
    public function render(
        Request $request,
        RenderHandler $handler,
        Settings $settings,
        Cart $cart,
        Captcha $captcha,
        Auth $auth,
        Persistence $persistence)
    {
        try {
            $dto = $handler->handle(
                (int)($request->get('page') ?? 1),
                (int)$request->route('server'),
                (int)$request->route('category')
            );
        } catch (ServerDoesNotExistException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        } catch (CategoryDoesNotExistException $e) {
            return (new JsonResponse('category_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }

        $server = $persistence->retrieve();
        if ($server !== null) {
            $server = new Server($server);

            // If the server is disabled and the user does not have permission to access the disabled servers.
            if (!ServerAccess::isUserHasAccessTo($auth->getUser(), $server->getEntity())) {
                return (new JsonResponse(Status::FORBIDDEN))
                    ->setHttpStatus(Response::HTTP_FORBIDDEN);
            }
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
            'captchaKey' => $captcha->key(),
            'currentServer' => $server,
            'productsCrudAccess' => $productsCrudAccess,
            'itemsCrudAccess' => $itemsCrudAccess
        ]);
    }

    /**
     * Processes the quick purchase for execution request from the directory.
     *
     * @param PurchaseRequest $request
     * @param PurchaseHandler $handler
     *
     * @return JsonResponse
     */
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
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.frontend.shop.catalog.product_not_found')));
        } catch (InvalidAmountException $e) {
            return (new JsonResponse('invalid_amount'))
                ->setHttpStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
                ->addNotification(new Warning(__('msg.frontend.shop.catalog.purchase.invalid_amount')));
        } catch (DistributionException $e) {
            return (new JsonResponse('distribution_failed'))
                ->setHttpStatus(Response::HTTP_ACCEPTED)
                ->addNotification(new Warning(__('msg.frontend.shop.catalog.purchase.distribution_failed')));
        } catch (ForbiddenException $e) {
            return (new JsonResponse('server_disabled'))
                ->setHttpStatus(Response::HTTP_FORBIDDEN)
                ->addNotification(new Warning(__('msg.forbidden')));
        }
    }
}
