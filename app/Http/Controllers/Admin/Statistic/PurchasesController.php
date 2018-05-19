<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Statistic;

use App\Entity\Purchase;
use App\Exceptions\Purchase\AlreadyCompletedException;
use App\Handlers\Admin\Statistic\Purchases\CompleteHandler;
use App\Handlers\Admin\Statistic\Purchases\PaginationHandler;
use App\Http\Controllers\Controller;
use function App\permission_middleware;
use App\Services\Auth\Permissions;
use App\Services\DateTime\Formatting\JavaScriptFormatter;
use App\Services\Notification\Notifications\Success;
use App\Services\Notification\Notifications\Warning;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Purchasing\ViaContext;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware(permission_middleware(Permissions::ADMIN_STATISTIC_PURCHASES_ACCESS))
            ->only('pagination');
        $this->middleware(permission_middleware(Permissions::ALLOW_COMPLETE_PURCHASES))
            ->only('complete');
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
                'via' => [
                    'quick' => $purchase->getVia() === ViaContext::QUICK,
                    'byAdmin' => $purchase->getVia() === ViaContext::BY_ADMIN,
                    'value' => $purchase->getVia()
                ],
                'completedAt' => (new JavaScriptFormatter())->format($purchase->getCompletedAt())
            ]))
                ->addNotification(new Success(__('msg.admin.statistic.purchases.complete.success')));
        } catch (AlreadyCompletedException $e) {
            return (new JsonResponse('already_completed'))
                ->setHttpStatus(Response::HTTP_CONFLICT)
                ->addNotification(new Warning(__('msg.admin.statistic.purchases.complete.already_completed')));
        }
    }
}
