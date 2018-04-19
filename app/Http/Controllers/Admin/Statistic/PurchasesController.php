<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Statistic;

use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Handlers\Admin\Statistic\Purchases\CompleteHandler;
use App\Handlers\Admin\Statistic\Purchases\PaginationHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\DateTime\Formatting\JavaScriptFormatter;
use App\Services\Infrastructure\Notification\Notifications\Success;
use App\Services\Infrastructure\Notification\Notifications\Warning;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_STATISTIC_PURCHASES_ACCESS));
    }

    public function pagination(Request $request, PaginationHandler $handler): JsonResponse
    {
        $page = is_numeric($request->get('page')) ? (int)$request->get('page') : 1;
        $perPage = is_numeric($request->get('per_page')) ? (int)$request->get('per_page') : 25;
        $orderBy = $request->get('order_by');
        $descending = (bool)$request->get('descending');

        $dto = $handler->handle($page, $perPage, $orderBy, $descending);

        return new JsonResponse(Status::SUCCESS, $dto);
    }

    /**
     * Complete the order with the received identifier if it exists and has not yet been completed.
     *
     * @param Request         $request
     * @param CompleteHandler $handler
     *
     * @return JsonResponse
     */
    public function complete(Request $request, CompleteHandler $handler): JsonResponse
    {
        try {
            $purchase = $handler->handle((int)$request->route('purchase'));

            return (new JsonResponse(Status::SUCCESS, [
                'completedAt' => (new JavaScriptFormatter())->format($purchase->getCompletedAt())
            ]))
                ->addNotification(new Success(__('msg.admin.statistic.purchases.complete.success')));
        } catch (AlreadyCompletedException $e) {
            return (new JsonResponse('already_completed'))
                ->addNotification(new Warning(__('msg.admin.statistic.purchases.complete.already_completed')));
        }
    }
}
