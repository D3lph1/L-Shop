<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

use App\DataTransferObjects\PaginationList;
use App\Exceptions\Item\ItemNotFoundException;
use App\Handlers\Admin\Items\DeleteHandler;
use App\Handlers\Admin\Items\ListHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Warning;
use App\Services\Notification\Notificator;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_ITEMS_CRUD_ACCESS));
    }

    public function pagination(Request $request, ListHandler $handler)
    {
        $dto = $handler->handle(
            (new PaginationList())
                ->setOrderBy($request->get('order_by') ?? 'id')
                ->setDescending((bool)$request->get('descending'))
                ->setSearch($request->get('search'))
                ->setPage((int)($request->get('page') ?? 1))
                ->setPerPage((int)($request->get('per_page') ?? 25))
        );

        return new JsonResponse(Status::SUCCESS, [
            'paginator' => $dto->getPaginator(),
            'items' => $dto->getItems()
        ]);
    }

    public function delete(Request $request, DeleteHandler $handler, Notificator $notificator): JsonResponse
    {
        try {
            $handler->handle((int)$request->get('item'));
            $notificator->notify(new Info(__('msg.admin.items.list.delete.success')));

            return new JsonResponse(Status::SUCCESS);
        } catch (ItemNotFoundException $e) {
            $notificator->notify(new Warning(__('msg.admin.items.list.delete.not_found')));

            return (new JsonResponse('item_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }
    }
}
