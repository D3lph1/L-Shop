<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products;

use App\Entity\Product as Entity;
use App\Services\Media\Image;
use App\Services\Product\Stack;

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
            'price' => $this->product->getPrice(),
            'stack' => Stack::formatUnits($this->product),
            'item' => [
                'name' => $this->product->getItem()->getName(),
                'image' => Image::itemImagePath($this->product->getItem()->getImage()),
                'type' => __("common.item.type.{$this->product->getItem()->getType()}")
            ]
        ];
    }
}
