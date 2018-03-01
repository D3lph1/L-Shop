<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic;

use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class ShowController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_STATISTIC_SHOW_ACCESS));
    }

    public function render(): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS);
    }
}
