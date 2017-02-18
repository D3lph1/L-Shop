<?php

namespace App\Http\Controllers\Payment;

use App\Services\PaymentAssistant\Payments\Robokassa;
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
     * @var QueryManager
     */
    private $qm;

    /**
     * @var \stdClass
     */
    private $payment;

    /**
     * @param QueryManager $qm
     */
    public function __construct(QueryManager $qm)
    {
        $this->qm = $qm;
    }

    /**
     * Handle request payment request from robokassa service
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function robokassa(Request $request)
    {
        $robokassa = \App::make('payment.robokassa');
        //if ($robokassa->validateResult($request->all())) {
            $this->payment = $this->qm->payment(
                68,
                ['id', 'products', 'cost', 'user_id', 'username']
            );

            // If payment with this ID does not exist, exit
            if (!$this->payment) {
                return response()->make('Failed', 400);
            }
            $this->give();

            return response()->make($robokassa->getSuccessAnswer());
        //}

        //return response()->make('Failed', 400);
    }

    private function give()
    {
        if ($this->payment->products) {
            return $this->giveProducts();
        }else if ($this->payment->cost){
            return $this->giveMoney();
        }

        throw new \UnexpectedValueException(
            "Columns `products` and `cost` is empty in row with id {$this->payment->id}"
        );
    }

    private function giveProducts()
    {
        //
    }

    private function giveMoney()
    {
        if ($this->payment->user_id) {
            $user = \Sentinel::getUserRepository()->findById($this->payment->user_id);
            if (!$user) {
                throw new \UnexpectedValueException(
                    "User with id {$this->payment->user_id} not found in row with id {$this->payment->id}"
                );
            }

            $user->update([
                'balance' => $user->getBalance() + $this->payment->cost
            ]);

            return true;
        }

        throw new \UnexpectedValueException(
            "Column `user_id` is empty in row with id {$this->payment->id}"
        );
    }

    private function completePayment()
    {
        //
    }
}
