<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Admin\Servers\Add\Add;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Handlers\Admin\Servers\Add\AddHandler;
use App\Handlers\Admin\Servers\Add\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Servers\AddEditRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Response;

class AddController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_SERVERS_CRUD_ACCESS));
    }

    public function render(RenderHandler $handler): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, $handler->handle());
    }

    public function add(AddEditRequest $request, AddHandler $handler): JsonResponse
    {
        try {
            $handler->handle(
                (new Add($request->get('name'), $request->get('distributor')))
                    ->setCategories($request->get('categories'))
                    ->setIp($request->get('ip'))
                    ->setPort($request->get('port') !== null ? (int)$request->get('port') : null)
                    ->setPassword($request->get('password'))
                    ->setMonitoringEnabled((bool)$request->get('monitoring_enabled'))
                    ->setServerEnabled((bool)$request->get('server_enabled'))
                    ->setDistributor($request->get('distributor'))
            );

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.servers.add.success')));
        } catch (DistributorNotFoundException $e) {
            return (new JsonResponse('distributor_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Success(__('msg.admin.servers.add.distributor_not_found')));
        }
    }
}
