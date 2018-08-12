<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop;

use App\DataTransferObjects\Frontend\Shop\Catalog\Enchantment;
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
        $enchantments = [];
        foreach ($this->cartItem->getProduct()->getItem()->getEnchantmentItems() as $enchantmentItem) {
            $enchantments[] = new Enchantment($enchantmentItem);
        }

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
                        'isCurrency' => $this->cartItem->getProduct()->getItem()->getType() === Type::CURRENCY,
                        'isRegionOwner' => $this->cartItem->getProduct()->getItem()->getType() === Type::REGION_OWNER,
                        'isRegionMember' => $this->cartItem->getProduct()->getItem()->getType() === Type::REGION_MEMBER,
                        'isCommand' => $this->cartItem->getProduct()->getItem()->getType() === Type::COMMAND,
                    ],
                    'image' => Image::assetPathOrDefault($this->cartItem->getProduct()->getItem()->getImage()),
                    'enchantments' => $enchantments
                ]
            ],
            'amount' => $this->cartItem->getAmount()
        ];
    }
}
