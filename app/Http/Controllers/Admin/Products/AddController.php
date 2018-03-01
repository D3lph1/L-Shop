<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\Handlers\Admin\Products\AddHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class AddController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PRODUCTS_CRUD_ACCESS));
    }

    public function render(AddHandler $handler): JsonResponse
    {
        $dto = $handler->handle();

        return new JsonResponse(Status::SUCCESS, [
            'items' => $dto->getItems(),
            'servers' => $dto->getServers()
        ]);
    }
}
