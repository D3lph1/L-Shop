<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\Exceptions\Page\DoesNotExistException;
use App\Handlers\Admin\Pages\DeleteHandler;
use App\Handlers\Admin\Pages\ListHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Error;
use App\Services\Infrastructure\Notification\Notifications\Info;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_PAGES_CRUD_ACCESS));
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
            'pages' => $dto->getPages()
        ]);
    }

    public function delete(Request $request, DeleteHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->get('page'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.pages.list.delete.success')));
        } catch (DoesNotExistException $e) {
            return (new JsonResponse('does_not_exists'))
                ->addNotification(new Error(__('msg.admin.pages.list.delete.not_found')));
        }
    }
}
