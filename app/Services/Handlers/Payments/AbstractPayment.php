<?php

namespace App\Services\Handlers\Payments;

use App\Exceptions\Payment\AlreadyCompletedException;
use App\Exceptions\Payment\NotFoundException;
use App\Exceptions\Payment\UnableToCompleteException;
use App\Repositories\PaymentRepository;

/**
 * Class AbstractPayment
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Handlers\Payments
 */
abstract class AbstractPayment
{
    /**
     * @var PaymentRepository
     */
    protected $paymentRepository;

    /**
     * @param array    $requestData
     * @param bool     $testing
     * @param null|int $testingPaymentId
     *
     * @return mixed
     */
    abstract public function handle(array $requestData, $testing, $testingPaymentId = null);

    /**
     * @param mixed $payment
     */
    protected function validatePayment($payment)
    {
        // If payment has already been completed.
        if ($payment->completed) {
            throw new AlreadyCompletedException();
        }

        // If payment with this ID does not exist, exit.
        if (!$payment) {
            throw new NotFoundException();
        }
    }

    /**
     * @param int $id Payment identifier.
     *
     * @return mixed
     */
    protected function payment($id)
    {
        return $this->paymentRepository->find((int)$id, [
            'id',
            'products',
            'cost',
            'user_id',
            'server_id',
            'username',
            'completed'
        ]);
    }

    /**
     * Give items or money.
     *
     * @param \App\Repositories\Payment $payment
     */
    protected function give(\App\Repositories\Payment $payment)
    {
        \DB::transaction(function () use ($payment) {
            if ($payment->products) {
                $this->giveProducts($payment);
            } else {
                $this->giveMoney($payment);
            }

            if (!$this->paymentRepository->complete($payment->id, static::SERVICE_NAME)) {
                throw new UnableToCompleteException();
            }
        });
    }

    /**
     * Outstanding product player.
     *
     * @param \App\Repositories\Payment $payment
     */
    private function giveProducts(\App\Repositories\Payment $payment)
    {
        $distributor = \App::make('distributor');
        $distributor->give($payment);
    }

    /**
     * Outstanding money player.
     *
     * @param \App\Repositories\Payment $payment
     */
    private function giveMoney(\App\Repositories\Payment $payment)
    {
        refill_user_balance($payment->cost, $payment->user_id);
    }
}
