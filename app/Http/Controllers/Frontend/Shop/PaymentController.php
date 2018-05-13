<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Purchase\PurchaseNotFoundException;
use App\Handlers\Frontend\Shop\Payment\VisitHandler;
use App\Http\Controllers\Controller;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PaymentController
 * Processes requests from the payment method selection page.
 */
class PaymentController extends Controller
{
    /**
     * Returns the data to render the payment method selection page.
     *
     * @param Request      $request
     * @param VisitHandler $handler
     *
     * @return Response
     */
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
