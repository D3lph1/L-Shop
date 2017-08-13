<?php

namespace App\Services\Distributors;

use App\Repositories\CartRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use App\Models\Payment;
use App\Exceptions\FailedToInsertException;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ShoppingCart
 * It produces products issue in the player shopping cart plugin table.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Distributors
 */
class ShoppingCart extends Distributor
{
    /**
     * @var CartRepository
     */
    protected $cartRepository;

    /**
     * ShoppingCart constructor.
     *
     * @param CartRepository    $cartRepository
     * @param ProductRepository $productRepository
     * @param PaymentRepository $paymentRepository
     */
    public function __construct(
        CartRepository $cartRepository,
        ProductRepository $productRepository,
        PaymentRepository $paymentRepository
    )
    {
        $this->cartRepository = $cartRepository;
        parent::__construct($productRepository, $paymentRepository);
    }

    /**
     * {@inheritdoc}
     */
    public function give(Payment $payment)
    {
        $this->payment = $payment;
        $this->setUser();
        \DB::transaction(function () use ($payment) {
            $products = $this->productsWithItems($payment->products);
            $this->putInTable($this->prepareInsertData($products));
            $this->complete();
        });
    }

    /**
     * @param Collection $products
     *
     * @return array Array with the goods that need to be given to the user.
     *               Example:
     *               [
     *                  [
     *                      'server' => 1,          // Server identifier.
     *                      'player' => D3lph1,     //Player nickname.
     *                      'type' => 'item',       // Type of item (item/permgroup).
     *                      'item' => 33,           // Item identifier in Minecraft.
     *                      'amount' => 16,         // Amount of items.
     *                      'extra' => null,        // Extra data for item.
     *                      'item_id' => 5,         // Item identifier in L-Shop.
     *                      // Date timestamps...
     *                  ],
     *                  [
     *                      //
     *                  ]
     *               ]
     */
    private function prepareInsertData($products)
    {
        $insertData = [];

        foreach ($products as $product) {
            // If the current product is a privilege.
            if ($product->type == 'permgroup') {
                if ($product->count) {
                    $item = $product->item . '?lifetime=' . $product->count * 86400;
                } else {
                    $item = $product->item;
                }
                $amount = 1;
            } else {
                // If the current product is a simple item.
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
        if (!$this->cartRepository->insert($insertData)) {
            throw new FailedToInsertException();
        }
    }
}
