<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\DataTransferObjects\Frontend\Shop\Server;
use App\Exceptions\Category\DoesNotExistException as CategoryDoesNotExistException;
use App\Exceptions\Server\DoesNotExistException as ServerDoesNotExistException;
use App\Handlers\Frontend\Shop\Catalog\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    public function render(
        Request $request,
        VisitHandler $handler,
        Settings $settings,
        Cart $cart,
        Captcha $captcha,
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
            'currentServer' => $server
        ]);
    }
}
