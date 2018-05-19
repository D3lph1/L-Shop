<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use function App\auth_middleware;
use App\Handlers\Frontend\Shop\ReplenishmentHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Shop\BalanceReplenishmentRequest;
use App\Services\Auth\AccessMode;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;

class ReplenishmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(auth_middleware(AccessMode::AUTH));
    }

    public function handle(BalanceReplenishmentRequest $request, ReplenishmentHandler $handler): JsonResponse
    {
        $handler->handle((float)$request->get('sum'), $request->ip());

        return new JsonResponse(Status::SUCCESS);
    }
}
