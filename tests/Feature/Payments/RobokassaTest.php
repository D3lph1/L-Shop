<?php

namespace Tests\Feature\Payments;

use App\Repositories\CartRepository;
use App\Services\Handlers\Payments\Robokassa;
use Tests\TestCase;

class RobokassaTest extends TestCase
{
    /**
     * @return void
     */
    public function testCreateAndCompleteBalance()
    {
        $paymentRepository = \App::make('App\Repositories\PaymentRepository');
        $userId = 1;
        $user = \Sentinel::getUserRepository()->findById($userId);
        $balance = $user->balance;

        $payment = $paymentRepository->create([
            'cost' => 33,
            'user_id' => $userId,
            'server_id' => 1,
            'ip' => '127.0.0.1',
            'completed' => 0
        ]);

        $this->createAndComplete($payment);

        $user = \Sentinel::getUserRepository()->findById($userId);
        $this->assertEquals($balance + 33, $user->balance);

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

        $this->app->make(CartRepository::class)->truncate();
        $this->createAndComplete($payment);
        $this->assertCart($payment);
        $paymentRepository->delete($payment->id);
    }

    /**
     * @param Payment $payment
     */
    private function createAndComplete(Payment $payment)
    {
        /** @var Robokassa $handler */
        $handler = \App::make('App\Services\Handlers\Payments\Robokassa');
        $id = $payment->id;
        $handler->handle([], true, $id);
    }

    /**
     * @param Payment $payment
     */
    private function assertCart(Payment $payment)
    {
        /** @var CartRepository $paymentRepository */
        $cartRepository = $this->app->make(CartRepository::class);

        /** @var Cart $last */
        $cart = $cartRepository->all();

        $unserializedProducts = unserialize($payment->products);
        $count = [];
        $amount = [];

        /** @var Cart $one */
        foreach ($cart as $one) {
            $count[] = current($unserializedProducts);
            $amount[] = $one->amount;
            next($unserializedProducts);
        }

        $this->assertEquals($count, $amount);
    }
}
