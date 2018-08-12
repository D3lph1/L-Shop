<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Edit;

use App\Entity\Product as Entity;
use App\Services\Item\Image\Image;
use App\Services\Item\Type;

class Product implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $product;

    public function __construct(Entity $product)
    {
        $this->product = $product;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->product->getId(),
            'item' => [
                'id' => $this->product->getItem()->getId(),
                'name' => $this->product->getItem()->getName(),
                'image' => Image::assetPathOrDefault($this->product->getItem()->getImage()),
                'type' => [
                    'isItem' => $this->product->getItem()->getType() === Type::ITEM,
                    'isPermgroup' => $this->product->getItem()->getType() === Type::PERMGROUP,
                    'isCurrency' => $this->product->getItem()->getType() === Type::CURRENCY,
                    'isRegionOwner' => $this->product->getItem()->getType() === Type::REGION_OWNER,
                    'isRegionMember' => $this->product->getItem()->getType() === Type::REGION_MEMBER,
                    'isCommand' => $this->product->getItem()->getType() === Type::COMMAND,
                ]
            ],
            'category' => [
                'id' => $this->product->getCategory()->getId()
            ],
            'price' => $this->product->getPrice(),
            'stack' => $this->product->getStack(),
            'sort_priority' => $this->product->getSortPriority(),
            'hidden' => $this->product->isHidden()
        ];
    }
}
