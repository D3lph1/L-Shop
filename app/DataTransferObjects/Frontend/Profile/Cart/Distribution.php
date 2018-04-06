<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Cart;

use App\Entity\Distribution as Entity;
use App\Services\Item\Image\Image;
use App\Services\Product\Stack;

class Distribution implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $purchaseItem = $this->entity->getPurchaseItem();

        return [
            'amount' => Stack::formatUnitsForAmount($purchaseItem->getProduct(), $purchaseItem->getAmount()),
            'item' => [
                'name' => $purchaseItem->getProduct()->getItem()->getName(),
                'image' => Image::assetPathOrDefault($purchaseItem->getProduct()->getItem()->getImage())
            ],
            'product' => [
                'server' => $purchaseItem->getProduct()->getCategory()->getServer()->getName(),
                'category' => $purchaseItem->getProduct()->getCategory()->getName()
            ]
        ];
    }
}
