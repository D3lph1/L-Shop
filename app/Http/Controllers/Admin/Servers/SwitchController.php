<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\Exceptions\Server\ServerNotFoundException;
use App\Handlers\Admin\Servers\SwitchState\DisableHandler;
use App\Handlers\Admin\Servers\SwitchState\EnableHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Info;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

class SwitchController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::SWITCH_SERVERS_STATE));
    }

    public function enable(Request $request, EnableHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('server'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.servers.switch.enabled')));
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.switch.server_not_found')));
        }
    }

    public function disable(Request $request, DisableHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('server'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.servers.switch.disabled')));
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.switch.server_not_found')));
        }
    }
}
