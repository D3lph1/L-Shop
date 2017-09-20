<?php
declare(strict_types = 1);

namespace App\Services\Distributors;

use App\Exceptions\FailedToInsertException;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Payment\PaymentInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ShoppingCart
 * It produces products issue in the player shopping cart plugin table.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Distributors
 */
class ShoppingCart extends Distributor
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    public function give(PaymentInterface $payment): void
    {
        $username = $this->getUsername($payment);

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

    private function putInTable(array $data): void
    {
        if (!$this->cartRepository->create($data)) {
            throw new FailedToInsertException();
        }
    }
}
