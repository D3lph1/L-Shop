<?php

namespace Tests\Feature\Payments;

use App\DataTransferObjects\Payment;
use App\Models\Cart\CartInterface;
use App\Models\Payment\PaymentInterface;
use App\Models\User\UserInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Services\Handlers\Payments\Robokassa;
use Tests\TestCase;

/**
 * Class RobokassaTest
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Payments
 */
class RobokassaTest extends TestCase
{
    public function testCreateAndCompleteBalance(): void
    {
        $paymentRepository = \App::make(PaymentRepositoryInterface::class);
        $userId = 1;
        /** @var UserInterface $user */
        $user = \Sentinel::getUserRepository()->findById($userId);
        $balance = $user->getBalance();

        $payment = $paymentRepository->create(
            $this->make(PaymentInterface::class)
                ->setCost(33)
                ->setUserId($userId)
                ->setServerId(1)
                ->setIp('127.0.0.1')
                ->setCompleted(false)
        );

        $this->createAndComplete($payment);

        $user = \Sentinel::getUserRepository()->findById($userId);
        $this->assertEquals($balance + 33, $user->getBalance());

        $paymentRepository->delete($payment->id);
    }

    public function testCreateAndCompleteItems(): void
    {
        /** @var PaymentRepositoryInterface $paymentRepository */
        $paymentRepository = $this->make(PaymentRepositoryInterface::class);

        $payment = $paymentRepository->create(
            $this->make(PaymentInterface::class)
                ->setProducts([14 => 64, 16 => 128])
                ->setCost(55)
                ->setUserId(1)
                ->setServerId(1)
                ->setIp('127.0.0.1')
                ->setCompleted(0)
        );

        $this->app->make(CartRepositoryInterface::class)->truncate();
        $this->createAndComplete($payment);
        $this->assertCart($payment);
        $paymentRepository->delete($payment->getId());
    }

    private function createAndComplete(PaymentInterface $payment): void
    {
        /** @var Robokassa $handler */
        $handler = \App::make(Robokassa::class);
        $handler->handle([], true, $payment->getId());
    }

    private function assertCart(PaymentInterface $payment): void
    {
        /** @var CartRepositoryInterface $paymentRepository */
        $cartRepository = $this->app->make(CartRepositoryInterface::class);

        /** @var CartInterface[] $last */
        $cart = $cartRepository->all();

        $unserializedProducts = $payment->getProducts();
        $count = [];
        $amount = [];

        /** @var CartInterface $one */
        foreach ($cart as $one) {
            $count[] = current($unserializedProducts);
            $amount[] = $one->getAmount();
            next($unserializedProducts);
        }

        $this->assertEquals($count, $amount);
    }
}
