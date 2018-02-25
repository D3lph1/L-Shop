<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class BasicController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_CONTROL_BASIC_ACCESS));
    }

    public function render()
    {
        return new JsonResponse(Status::SUCCESS);
    }
}
