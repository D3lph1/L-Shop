<?php

namespace App\Http\Controllers\Payment;

use App\Services\PaymentAssistant\Payments\Robokassa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ResultController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class ResultController extends Controller
{
    /**
     * Handle request payment request from robokassa service
     *
     * @param Request $request
     */
    public function robokassa(Request $request)
    {
        $robokassa = \App::make('payment.robokassa');
        echo $robokassa->getSuccessResponse($request->get('InvId'));
    }
}
