<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Exceptions\Distributor\DistributionException;
use App\Exceptions\Distributor\DistributionNotFoundException;
use App\Handlers\Frontend\Profile\Cart\DistributionHandler;
use App\Handlers\Frontend\Profile\Cart\PaginationHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

/**
 * Class CartController
 * Responsible for processing data for the in-game cart page.
 */
class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::PROFILE_GAME_CART_ACCESS));
    }

    /**
     * Displays information for paginating items on the page.
     *
     * @param Request           $request
     * @param PaginationHandler $handler
     *
     * @return JsonResponse
     */
    public function pagination(Request $request, PaginationHandler $handler): JsonResponse
    {
        $page = is_numeric($request->get('page')) ? (int)$request->get('page') : 1;
        $server = is_numeric($request->get('server')) ? (int)$request->get('server') : null;
        $orderBy = $request->get('order_by');
        $descending = (bool)$request->get('descending');

        $dto = $handler->handle($page, $server, $orderBy, $descending);

        return new JsonResponse(Status::SUCCESS, $dto);
    }

    /**
     * Handles a request for the distributing of products.
     *
     * @param Request             $request
     * @param DistributionHandler $handler
     *
     * @return JsonResponse
     */
    public function distribute(Request $request, DistributionHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('distribution'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.frontend.profile.cart.distribution.wait')));
        } catch (DistributionNotFoundException $e) {
            return (new JsonResponse('distribution_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Warning(__('msg.frontend.profile.cart.distribution.not_found')));
        } catch (DistributionException $e) {
            return (new JsonResponse(Status::FAILURE))
                ->setHttpStatus(Response::HTTP_ACCEPTED)
                ->addNotification(new Warning(__('msg.frontend.profile.cart.distribution.failure')));
        }
    }
}
