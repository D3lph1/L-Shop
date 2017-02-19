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
     * @var string
     */
    private $service;

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
        $this->service = 'robokassa';
        $robokassa = \App::make('payment.robokassa');
        if ($robokassa->validateResult($request->all())) {
            $this->payment = $this->qm->payment(
                $robokassa->getInvoiceId(),
                ['id', 'products', 'cost', 'user_id', 'username', 'complete']
            );

            if ($this->payment->complete) {
                return response()->make('Already complete', 400);
            }

            // If payment with this ID does not exist, exit
            if (!$this->payment) {
                return response()->make('Failed', 400);
            }
            $this->give();

            return response()->make($robokassa->getSuccessAnswer());
        }

        return response()->make('Failed', 400);
    }

    /**
     * Outstanding product or money player
     *
     *
     * @throws \UnexpectedValueException
     *
     * @return bool
     */
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

    /**
     * Outstanding product player
     */
    private function giveProducts()
    {
        $distributor = \App::make('distributor');
        $distributor->setQm($this->qm);
        if ($this->payment->user_id || $this->payment->username) {
            $distributor->give($this->payment);
            $this->completePayment($this->payment->id);

            return;
        }

        throw new \UnexpectedValueException(
            "Columns `user_id` and `username` is empty in row with id {$this->payment->id}"
        );
    }

    /**
     * Outstanding money player
     *
     * @throws \UnexpectedValueException
     *
     * @return bool
     */
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

            $this->completePayment($this->payment->id);
            return true;
        }
        throw new \UnexpectedValueException(
            "Column `user_id` is empty in row with id {$this->payment->id}"
        );
    }

    /**
     * @param int $id
     *
     * @throws FailedToUpdateTableException
     */
    private function completePayment($id)
    {
        if (!$this->qm->completePayment($id, $this->service)) {
            throw new FailedToUpdateTableException(
                "Unable to complete the payment with id $id"
            );
        }
    }
}
