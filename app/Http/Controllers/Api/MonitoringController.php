<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Handlers\Api\MonitoringHandler;
use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

class MonitoringController extends Controller
{
    public function monitor(MonitoringHandler $handler): JsonResponse
    {
        $objects = $handler->handle();

        return new JsonResponse(Status::SUCCESS, [
            'monitoring' => $objects
        ]);
    }
}
