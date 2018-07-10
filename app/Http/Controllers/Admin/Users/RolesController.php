<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;

class RolesController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_ROLES_CRUD_ACCESS));
    }

    public function pagination(): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS);
    }
}
