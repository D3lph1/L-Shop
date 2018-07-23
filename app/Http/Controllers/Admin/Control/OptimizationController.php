<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Control;

use App\Handlers\Admin\Control\Optimization\ResetAppCacheHandler;
use App\Handlers\Admin\Control\Optimization\VisitHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Control\SaveOptimizationRequest;
use App\Services\Auth\Permissions;
use App\Services\Notification\Notifications\Success;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Settings\Settings;
use function App\permission_middleware;

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

    public function resetAppCache(ResetAppCacheHandler $handler): JsonResponse
    {
        $handler->handle();

        return (new JsonResponse(Status::SUCCESS))
            ->addNotification(new Success(__('msg.admin.control.optimization.reset_app_cache_successfully')));
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
