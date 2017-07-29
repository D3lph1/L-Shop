<?php

namespace Tests\Feature\Payments;

use App\Exceptions\Payment\InvalidProductsCountException;
use App\Models\Cart;
use App\Models\Payment;
use App\Services\CatalogBuy;
use Illuminate\Container\Container;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BuyTest extends TestCase
{
    public function testItemWithAuth()
    {
        \Sentinel::login(\Sentinel::findById(1));

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

    /**
     * @param int         $productId
     * @param int         $count
     * @param null|string $username
     *
     * @return string
     */
    private function buy($productId, $count, $username = null)
    {
        /** @var $handler CatalogBuy */
        $handler = Container::getInstance()->make('App\Services\CatalogBuy');

        return $handler->buy($productId, $count, 1, '127.0.0.1', $username)->getData()->status;
    }

    /**
     * @param string $status
     */
    private function check($status)
    {
        if ($status === 'success') {
            // Clear table with payments
            Payment::truncate();

            $this->assertTrue(true);
        } else {

            $this->assertTrue(false);
        }
    }
}
