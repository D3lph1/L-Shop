<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Information;

use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Meta\System;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_INFORMATION_ABOUT_ACCESS));
    }

    public function render(): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, [
            'logo' => asset('img/layout/logo/small.png'),
            'version' => System::version()->formatted()
        ]);
    }
}
