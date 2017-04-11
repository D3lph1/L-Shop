<?php

namespace App\Http\Controllers\Payment;

use App\Exceptions\FailedToUpdateTableException;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ResultController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Payment
 */
class ResultController extends Controller
{
    /**
     * @var \stdClass
     */
    private $payment;

    /**
     * Current service name
     *
     * @var string
     */
    private $service;

    /**
     * Handle request payment request from robokassa service
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function robokassa(Request $request)
    {
        $this->service = 'robokassa';
        $robokassa = \App::make('payment.robokassa');
        if ($robokassa->validateResult($request->all())) {
            //Get payment with the specified identifier from the database
            $this->payment = $this->getPayment($robokassa->getInvoiceId());
            if (!$this->payment) {
                return response()->make('Payment not found', 404);
            }
            $this->payment->service = 'robokassa';

            // If payment has already been completed
            if ($this->payment->completed) {
                return response()->make('Already complete', 400);
            }
            // If payment with this ID does not exist, exit
            if (!$this->payment) {
                return response()->make('Payment not found', 400);
            }

            $this->give();

            return response()->make($robokassa->getSuccessAnswer());
        }

        return response()->make('Failed', 400);
    }

    /**
     * Outstanding product or money player
     */
    private function give()
    {
        \DB::transaction(function () {
            if ($this->payment->products) {
                $this->giveProducts();
            } else {
                $this->giveMoney();
            }

            $this->qm->completePayment($this->payment->id, $this->service);
        });
    }

    /**
     * Outstanding product player
     */
    private function giveProducts()
    {
        $distributor = \App::make('distributor');
        $distributor->give($this->payment);
    }

    /**
     * Outstanding money player
     */
    private function giveMoney()
    {
        refill_user_balance($this->payment->cost, $this->payment->user_id);
    }

    /**
     * @param int $id
     *
     * @return \Eloquent|\Illuminate\Database\Eloquent\Collection
     */
    private function getPayment($id)
    {
        return $this->qm->payment(
            $id,
            ['id', 'products', 'cost', 'user_id', 'server_id', 'username', 'completed']
        );
    }
}
