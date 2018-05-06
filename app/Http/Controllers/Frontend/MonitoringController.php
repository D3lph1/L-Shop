<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend;

use App\Handlers\Api\MonitoringHandler;
use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;

/**
 * Class MonitoringController
 * Handles requests related to online server statistics.
 */
class MonitoringController extends Controller
{
    /**
     * Processes a request for statistics on online servers.
     *
     * @param MonitoringHandler $handler
     *
     * @return JsonResponse
     */
    public function monitor(MonitoringHandler $handler): JsonResponse
    {
        $objects = $handler->handle();

        return new JsonResponse(Status::SUCCESS, [
            'monitoring' => $objects
        ]);
    }
}
