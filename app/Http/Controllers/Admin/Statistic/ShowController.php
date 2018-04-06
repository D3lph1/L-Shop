<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Statistic;

use App\Handlers\Admin\Statistic\Show\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class ShowController extends Controller
{
    public function render(Request $request, VisitHandler $handler): JsonResponse
    {
        $handler->handle();

        return new JsonResponse(Status::SUCCESS);
    }
}
