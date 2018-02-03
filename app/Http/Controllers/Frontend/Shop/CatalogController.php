<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\Category\DoesNotExistException as CategoryDoesNotExistException;
use App\Exceptions\Server\DoesNotExistException as ServerDoesNotExistException;
use App\Handlers\Frontend\Shop\Catalog\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CatalogController extends Controller
{
    public function render(Request $request, VisitHandler $handler, Settings $settings, Cart $cart, Captcha $captcha)
    {
        try {
            $dto = $handler->handle((int)$request->route('server'), (int)$request->route('category'));
        } catch (ServerDoesNotExistException $e) {
            throw new NotFoundHttpException();
        } catch (CategoryDoesNotExistException $e) {
            throw new NotFoundHttpException();
        }

        return view('frontend.shop.catalog', [
            'shopName' => $settings->get('shop.name')->getValue(),
            'currency' => $settings->get('shop.currency.html')->getValue(),
            'server' => $dto->getServer(),
            'currentCategory' => $dto->getCurrentCategory(),
            'products' => $dto->getProducts(),
            'cart' => $cart,
            'captcha' => $captcha->view()
        ]);
    }
}
