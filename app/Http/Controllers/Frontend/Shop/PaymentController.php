<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Purchase\PurchaseNotFoundException;
use App\Handlers\Frontend\Shop\Payment\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentController extends Controller
{
    public function render(Request $request, VisitHandler $handler): Response
    {
        try {
            $payers = $handler->handle((int)$request->route('purchase'));

            return new Response(new JsonResponse(Status::SUCCESS, [
                'payers' => $payers
            ]));
        } catch (PurchaseNotFoundException $e) {
            return new Response(new JsonResponse('purchase_not_found'), 404);
        } catch (ForbiddenException $e) {
            return new Response(new JsonResponse(Status::FORBIDDEN), 403);
        }
    }
}
