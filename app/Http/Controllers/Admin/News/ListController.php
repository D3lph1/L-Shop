<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\PaginationList;
use App\Handlers\Admin\News\ListHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use function App\permission_middleware;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_NEWS_CRUD_ACCESS));
    }

    public function pagination(Request $request, ListHandler $handler): JsonResponse
    {
        $dto = $handler->handle(
            (new PaginationList())
                ->setOrderBy($request->get('order_by'))
                ->setDescending((bool)$request->get('descending'))
                ->setSearch($request->get('search'))
                ->setPage((int)$request->get('page'))
                ->setPerPage((int)$request->get('per_page'))
        );

        return new JsonResponse(Status::SUCCESS, $dto);
    }
}
