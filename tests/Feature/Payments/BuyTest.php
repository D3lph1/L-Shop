<?php

namespace Tests\Feature\Payments;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Services\CatalogBuy;
use App\TransactionScripts\Shop\Catalog;
use Illuminate\Container\Container;
use Tests\TestCase;

/**
 * Class BuyTest
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package Tests\Feature\Payments
 */
class BuyTest extends TestCase
{
    public function testItemWithAuth()
    {
        \Sentinel::login(\Sentinel::getUserRepository()->findById(1));

        // 2 stacks green grass block
        $status = $this->buy(14, 128);

        $this->check($status);
    }

    public function testBuyItemWithNotAuth()
    {
        // 2 stacks green grass block
        $status = $this->buy(14, 128, 'D3lph1');

        $this->check($status);
    }

    public function testBuyItemWithZeroCount()
    {
        try {
            $this->buy(14, 0, 'D3lph1');
        } catch (InvalidProductsCountException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->assertTrue(false);
    }

    public function testBuyItemWithInvalidCount()
    {
        try {
            $this->buy(14, 15, 'D3lph1');
        } catch (InvalidProductsCountException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->assertTrue(false);
    }

    public function testBuyPerm()
    {
        $status = $this->buy(20, 30, 'D3lph1');

        $this->check($status);
    }

    public function testBuyPermZeroCount()
    {
        try {
            $this->buy(20, 0, 'D3lph1');
        } catch (InvalidProductsCountException $e) {
            $this->assertTrue(true);

            return;
        }

        $this->assertTrue(false);
    }

    public function testBuyPermPermanently()
    {
        $status = $this->buy(21, 0, 'D3lph1');

        $this->check($status);
    }

    public function testBuyPermPermanentlyNonZero()
    {
        $status = $this->buy(21, 15, 'D3lph1');

        $this->check($status);
    }

    private function buy($productId, $count, $username = null)
    {
        /** @var $handler Catalog */
        $handler = Container::getInstance()->make(Catalog::class);

        return $handler->purchase($productId, $count, 1, '127.0.0.1', $username)->getData()->status;
    }

    /**
     * @param string $status
     */
    private function check($status)
    {
        if ($status === 'success') {
            // Clear table with payments.
            /** @var PaymentRepositoryInterface $repository */
            $repository = $this->make(PaymentRepositoryInterface::class);
            $repository->truncate();

            $this->assertTrue(true);
        } else {

            $this->assertTrue(false);
        }
    }
}
