<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Other;

use App\Http\Controllers\Controller;
use App\Services\Auth\Permissions;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use function App\permission_middleware;

class RconController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_OTHER_RCON_ACCESS));
    }

    public function render(Request $request): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS);
    }
}
