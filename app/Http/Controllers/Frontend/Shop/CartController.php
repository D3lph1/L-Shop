<?php
declare(strict_types=1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\Product\DoesNotExistException;
use App\Handlers\Frontend\Shop\Cart\PutHandler;
use App\Handlers\Frontend\Shop\Cart\RemoveHandler;
use App\Handlers\Frontend\Shop\Cart\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shop\Cart\PutRequest;
use App\Http\Requests\Frontend\Shop\Cart\RemoveRequest;
use App\Services\Auth\Auth;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Settings\Settings;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function render(Request $request, VisitHandler $handler, Auth $auth, Settings $settings, Captcha $captcha)
    {
        return view('frontend.shop.cart', [
            'isAuth' => $auth->check(),
            'currency' => $settings->get('shop.currency.html')->getValue(),
            'cart' => $handler->handle((int)$request->route('server')),
            'captcha' => $captcha->view()
        ]);
    }

    public function put(PutRequest $request, PutHandler $handler)
    {
        $handler->handle($request->get('product'));

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.shop.cart.success.message')));
    }

    public function remove(RemoveRequest $request, RemoveHandler $handler)
    {
        try {
            $handler->handle($request->get('product'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.shop.cart.remove.success')));
        } catch (DoesNotExistException $e) {
            return (new JsonResponse('product_does_not_exist'))
                ->addNotification(new Warning(__('msg.shop.cart.remove.fail')));
        }
    }
}
