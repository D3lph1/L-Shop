<?php
declare(strict_types = 1);

namespace App\Services\Distributors;

use App\Exceptions\FailedToInsertException;
use App\Exceptions\UnexpectedValueException;
use App\Models\Payment\PaymentInterface;
use App\Models\Product\ProductInterface;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Services\Items\Type;
use DB;

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
        DB::transaction(function () use ($payment) {
            $username = $this->getUsername($payment);
            $products = $this->productsWithItems($payment->getProducts());
            $this->putInTable($this->prepareInsertData($payment, $products, $username));
            $this->complete($payment);
        });
    }

    /**
     * @param array $data
     *               Example:
     *               [
     *                  [
     *                      'product' => <instanceof ProductInterface>,
     *                      'count' => 64
     *                  ],
     *                  [
     *                      'product' => <instanceof ProductInterface>,
     *                      'count' => 1
     *                  ],
     *                  [
     *                      //
     *                  ]
     *               ]
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
    private function prepareInsertData(PaymentInterface $payment, array $data, string $username)
    {
        $insertData = [];

        foreach ($data as $one) {
            /** @var ProductInterface $product */
            $product = $one['product'];
            // If the current product is a privilege.
            if ($product->getItem()->getType() === Type::PERMGROUP) {
                if ($one['count']) {
                    $item = $product->getItem()->getItem() . '?lifetime=' . $one['count'] * 86400;
                } else {
                    $item = $product->getItem()->getItem();
                }
                $amount = 1;
            } else if ($product->getItem()->getType() === Type::ITEM) {
                // If the current product is a simple item.
                $item = $product->getItem()->getItem();
                $amount = $one['count'];
            } else {
                throw new UnexpectedValueException("Unexpected item type `{$product->getItem()->getType()}`");
            }

            $insertData[] = [
                'server' => $payment->getServerId(),
                'player' => $username,
                'type' => $product->getItem()->getType(),
                'item' => $item,
                'amount' => $amount,
                'extra' => $product->getItem()->getExtra(),
                'item_id' => $product->getItem()->getId()
            ];
        }

        return $insertData;
    }

    /**
     * Insert data in shopping cart payment
     */
    private function putInTable(array $data): void
    {
        if (!$this->cartRepository->insert($data)) {
            throw new FailedToInsertException();
        }
    }
}
