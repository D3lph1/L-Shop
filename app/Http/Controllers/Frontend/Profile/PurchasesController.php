<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Profile;

use App\Handlers\Frontend\Profile\Purchases\PaginationHandler;
use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;

class PurchasesController extends Controller
{
    public function pagination(Request $request, PaginationHandler $handler): JsonResponse
    {
        $page = is_numeric($request->get('page')) ? (int)$request->get('page') : 1;
        $orderBy = $request->get('order_by');
        $descending = (bool)$request->get('descending');
        $perPage = (int)$request->get('per_page');

        $dto = $handler->handle($page, $orderBy, $descending, $perPage);

        return new JsonResponse(Status::SUCCESS, [
            'paginator' => $dto->getPaginator(),
            'items' => $dto->getItems()
        ]);
    }
}
