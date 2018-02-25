<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Catalog;

use App\Entity\Product as Entity;

class Product implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var bool
     */
    private $inCart;

    public function __construct(Entity $product, bool $inCart)
    {
        $this->entity = $product;
        $this->inCart = $inCart;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->entity->getId(),
            'item' => new Item($this->entity->getItem()),
            'price' => $this->entity->getPrice(),
            'stack' => $this->entity->getStack(),
            'inCart' => $this->inCart
        ];
    }
}
