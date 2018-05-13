<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Items;

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
use function App\permission_middleware;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_ITEMS_CRUD_ACCESS));
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

            return new JsonResponse('not_found');
        }
    }
}
