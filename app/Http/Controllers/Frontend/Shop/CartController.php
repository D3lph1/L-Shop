<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Handlers\Frontend\Shop\Cart\PutHandler;
use App\Handlers\Frontend\Shop\Cart\RemoveHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shop\Cart\PutRequest;
use App\Http\Requests\Frontend\Shop\Cart\RemoveRequest;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class CartController extends Controller
{
    public function render()
    {
        return view('frontend.shop.cart');
    }

    public function put(PutRequest $request, PutHandler $handler)
    {
        $handler->handle($request->get('product'));

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.shop.cart.success.message')));
    }

    public function remove(RemoveRequest $request, RemoveHandler $handler)
    {
        $handler->handle($request->get('product'));

        return new JsonResponse(Status::SUCCESS);
    }
}
