<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\Exceptions\Server\ServerNotFoundException;
use App\Handlers\Admin\Servers\ListHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Info;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use function App\permission_middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ListController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_SERVERS_CRUD_ACCESS));
    }

    public function render(ListHandler $handler): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, [
            'servers' => $handler->handle()
        ]);
    }

    public function delete(Request $request, DeleteHandler $handler): JsonResponse
    {
        try {
            return (new JsonResponse(Status::SUCCESS, $handler->handle((int)$request->route('server'))))
                ->addNotification(new Info(__('msg.admin.servers.delete.success')));
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.delete.not_found')));
        }
    }
}
