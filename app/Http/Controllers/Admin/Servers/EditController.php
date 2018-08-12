<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\DataTransferObjects\Admin\Servers\Edit\Edit;
use App\DataTransferObjects\Admin\Servers\Edit\EditedCategory;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Exceptions\Server\ServerNotFoundException;
use App\Handlers\Admin\Servers\Edit\EditHandler;
use App\Handlers\Admin\Servers\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Servers\EditRequest;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_SERVERS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        try {
            return new JsonResponse(Status::SUCCESS, $handler->handle((int)$request->route('server')));
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND);
        }
    }

    public function edit(EditRequest $request, EditHandler $handler): JsonResponse
    {
        $categories = [];
        foreach ($request->get('categories') as $category) {
            $newCategory = new EditedCategory($category['name']);
            if (isset($category['id'])) {
                $newCategory->setId($category['id']);
            }

            $categories[] = $newCategory;
        }

        try {
            $handler->handle(
                (new Edit((int)$request->route('server'), $request->get('name'), $request->get('distributor')))
                    ->setCategories($categories)
                    ->setIp($request->get('ip'))
                    ->setPort($request->get('port') !== null ? (int)$request->get('port') : null)
                    ->setPassword($request->get('password'))
                    ->setMonitoringEnabled((bool)$request->get('monitoring_enabled'))
                    ->setServerEnabled((bool)$request->get('server_enabled'))
                    ->setDistributor($request->get('distributor'))
            );

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.servers.edit.success')));
        } catch (ServerNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.edit.server_not_found')));
        } catch (CategoryNotFoundException $e) {
            return (new JsonResponse('server_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.edit.category_not_found')));
        } catch (DistributorNotFoundException $e) {
            return (new JsonResponse('distributor_not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.servers.edit.distributor_not_found')));
        }
    }
}
