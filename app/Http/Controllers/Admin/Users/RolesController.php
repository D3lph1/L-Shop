<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\DataTransferObjects\PaginationList;
use App\Exceptions\Role\RoleAlreadyExistsException;
use App\Exceptions\Role\RoleNotFoundException;
use App\Handlers\Admin\Users\Roles\DeleteHandler;
use App\Handlers\Admin\Users\Roles\PaginationHandler;
use App\Handlers\Admin\Users\Roles\UpdateNameHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Users\Roles\UpdateNameRequest;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Error;
use App\Services\Notification\Notifications\Info;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use function App\permission_middleware;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_ROLES_CRUD_ACCESS));
    }

    public function pagination(Request $request, PaginationHandler $handler): JsonResponse
    {
        $dto = $handler->handle(
            (new PaginationList())
                ->setOrderBy($request->get('order_by') ?? 'role.id')
                ->setDescending((bool)$request->get('descending'))
                ->setSearch($request->get('search'))
                ->setPage((int)($request->get('page') ?? 1))
                ->setPerPage((int)($request->get('per_page') ?? 25))
        );

        return new JsonResponse(Status::SUCCESS, $dto);
    }

    public function updateName(UpdateNameRequest $request, UpdateNameHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('role'), $request->get('name'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Success(__('msg.admin.users.roles.successfully_updated')));
        } catch (RoleNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.users.roles.not_found')));
        } catch (RoleAlreadyExistsException $e) {
            return (new JsonResponse('already_exists'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Error(__('msg.admin.users.roles.already_exists_with_name', [
                    'name' => $request->get('name')
                ])));
        }
    }

    public function delete(Request $request, DeleteHandler $handler): JsonResponse
    {
        try {
            $handler->handle((int)$request->route('role'));

            return (new JsonResponse(Status::SUCCESS))
                ->addNotification(new Info(__('msg.admin.users.roles.successfully_deleted')));
        } catch (RoleNotFoundException $e) {
            return (new JsonResponse('not_found'))
                ->setHttpStatus(Response::HTTP_NOT_FOUND)
                ->addNotification(new Error(__('msg.admin.users.roles.not_found')));
        }
    }
}
