<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Other;

use App\Handlers\Admin\Other\SendTestEmailHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Other\SendTestEmailRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class DebugController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_OTHER_DEBUG_ACCESS));
    }

    public function render(): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS);
    }

    public function sendEmail(SendTestEmailRequest $request, SendTestEmailHandler $handler): JsonResponse
    {
        try {
            $handler->handle($request->get('email'));

            return new JsonResponse(Status::SUCCESS);
        } catch (\Exception $e) {
            return new JsonResponse(Status::FAILURE, [
                'message' => $e->getMessage()
            ]);
        }
    }
}
