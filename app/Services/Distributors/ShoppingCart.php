<?php

namespace App\Services\Distributors;

use Carbon\Carbon;
use App\Models\Payment;
use App\Exceptions\FailedToInsertException;

/**
 * Class ShoppingCart
 * It produces goods issue in the player shopping cart plugin table
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Distributors
 */
class ShoppingCart extends Distributor
{
    /**
     * @param Payment $payment
     */
    public function give(Payment $payment)
    {
        $this->payment = $payment;
        $this->setUser();
        \DB::transaction(function () use ($payment) {
            $products = $this->convertProductsString($payment->products);
            $this->putInTable($this->prepareInsertData($products));
            $this->complete();
        });
    }

    /**
     * @param array $products
     *
     * @return array
     */
    private function prepareInsertData($products)
    {
        $insertData = [];
        foreach ($products as $product) {
            if ($product->type == 'permgroup') {
                if ($product->count) {
                    $item = $product->item . '?lifetime=' . $product->count * 86400;
                } else {
                    $item = $product->item;
                }
                $amount = 1;
            }else {
                $item = $product->item;
                $amount = $product->count;
            }

            $insertData[] = [
                'server' => $this->payment->server_id,
                'player' => $this->user,
                'type' => $product->type,
                'item' => $item,
                'amount' => $amount,
                'extra' => $product->extra,
                'item_id' => $product->item_id,
                'created_at' => Carbon::now()->toDateTimeString()
            ];
        }

        return $insertData;
    }

    /**
     * @param array $insertData
     *
     * @throws FailedToInsertException
     */
    private function putInTable($insertData)
    {
        if (!$this->qm->putInShoppingCart($insertData)) {
            throw new FailedToInsertException();
        }
    }
}
