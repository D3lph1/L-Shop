<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\Exceptions\User\DoesNotExistException;
use App\Handlers\Admin\Users\Edit\RenderHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EditController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_USERS_CRUD_ACCESS));
    }

    public function render(Request $request, RenderHandler $handler): JsonResponse
    {
        try {
            $dto = $handler->handle((int)$request->route('user'));

            return new JsonResponse(Status::SUCCESS, [
                'user' => $dto->getUser(),
                'roles' => $dto->getRoles(),
                'permissions' => $dto->getPermissions()
            ]);
        } catch (DoesNotExistException $e) {
            throw new NotFoundHttpException();
        }
    }

    public function edit(): JsonResponse
    {
        //
    }
}
