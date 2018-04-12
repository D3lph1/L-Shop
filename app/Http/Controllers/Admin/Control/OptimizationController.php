<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use App\Handlers\Admin\Control\Optimization\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Control\SaveOptimizationRequest;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Settings\Settings;

class OptimizationController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_CONTROL_OPTIMIZATION_ACCESS));
    }

    public function render(VisitHandler $handler): JsonResponse
    {
        return new JsonResponse(Status::SUCCESS, $handler->handle());
    }

    public function save(SaveOptimizationRequest $request, Settings $settings): JsonResponse
    {
        $settings->setArray([
            'system' => [
                'monitoring' => [
                    'rcon' => [
                        'ttl' => (int)$request->get('monitoring_ttl')
                    ]
                ]
            ]
        ]);
        $settings->save();

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('common.changed')));
    }
}
