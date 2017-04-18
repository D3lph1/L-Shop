<?php

namespace Tests\Feature\Payments;

use Tests\TestCase;
use App\Models\Payment;

class RobokassaTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateAndCompleteBalance()
    {
        $paymentRepository = \App::make('App\Repositories\PaymentRepository');

        $payment = $paymentRepository->create([
            'cost' => 33,
            'user_id' => 1,
            'server_id' => 1,
            'ip' => '127.0.0.1',
            'completed' => 0
        ]);

        $this->createAndComplete($payment);
        $paymentRepository->delete($payment->id);
    }

    /**
     * @return void
     */
    public function testCreateAndCompleteItems()
    {
        $paymentRepository = \App::make('App\Repositories\PaymentRepository');

        $payment = $paymentRepository->create([
            'products' => serialize([14 => 64, 16 => 128]),
            'user_id' => 1,
            'server_id' => 1,
            'ip' => '127.0.0.1',
            'completed' => 0
        ]);

        $this->createAndComplete($payment);
        $paymentRepository->delete($payment->id);
    }

    /**
     * @param Payment $payment
     */
    private function createAndComplete(Payment $payment)
    {
        $handler = \App::make('App\Services\Handlers\Payments\Robokassa');
        $id = $payment->id;
        $handler->handle([], true, $id);
    }
}
