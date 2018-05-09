<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Exceptions\Distributor\DistributionNotFoundException;
use App\Handlers\Frontend\Profile\Cart\DistributionHandler;
use App\Handlers\Frontend\Profile\Cart\PaginationHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::PROFILE_GAME_CART_ACCESS));
    }

    public function pagination(Request $request, PaginationHandler $handler): JsonResponse
    {
        $page = is_numeric($request->get('page')) ? (int)$request->get('page') : 1;
        $server = is_numeric($request->get('server')) ? (int)$request->get('server') : null;
        $orderBy = $request->get('order_by');
        $descending = (bool)$request->get('descending');

        $dto = $handler->handle($page, $server, $orderBy, $descending);

        return new JsonResponse(Status::SUCCESS, $dto);
    }

    public function distribute(Request $request, DistributionHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('distribution'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.profile.cart.distribution.wait')));
        } catch (DistributionNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->addNotification(new Warning(__('msg.frontend.profile.cart.distribution.not_found')));
        }
    }
}
