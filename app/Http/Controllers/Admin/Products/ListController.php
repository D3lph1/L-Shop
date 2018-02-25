<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\Handlers\Admin\Products\ListHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PRODUCTS_CRUD_ACCESS));
    }

    public function pagination(Request $request, ListHandler $handler)
    {
        $orderBy = $request->get('order_by');
        $descending = (bool)$request->get('descending');
        $search = $request->get('search');
        $perPage = (int)$request->get('per_page');

        $dto = $handler->handle($orderBy, $descending, $search, $perPage);

        return new JsonResponse(Status::SUCCESS, [
            'paginator' => $dto->getPaginator(),
            'products' => $dto->getProducts()
        ]);
    }
}
