<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop;

use App\Services\Cart\Item;
use App\Services\Item\Image\Image;
use App\Services\Item\Type;

class CartResult implements \JsonSerializable
{
    /**
     * @var Item
     */
    private $cartItem;

    public function __construct(Item $cartItem)
    {
        $this->cartItem = $cartItem;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'product' => [
                'id' => $this->cartItem->getProduct()->getId(),
                'stack' => $this->cartItem->getProduct()->getStack(),
                'price' => $this->cartItem->getProduct()->getPrice(),
                'item' => [
                    'name' => $this->cartItem->getProduct()->getItem()->getName(),
                    'type' => [
                        'isItem' => $this->cartItem->getProduct()->getItem()->getType() === Type::ITEM,
                        'isPermgroup' => $this->cartItem->getProduct()->getItem()->getType() === Type::PERMGROUP,
                    ],
                    'image' => Image::assetPathOrDefault($this->cartItem->getProduct()->getItem()->getImage())
                ]
            ],
            'amount' => $this->cartItem->getAmount()
        ];
    }
}
