<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Catalog;

use App\Entity\Item as Entity;
use App\Services\Item\Image\Image;
use App\Services\Item\Type;

class Item implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $item;

    public function __construct(Entity $item)
    {
        $this->item = $item;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->item->getName(),
            'description' => $this->item->getDescription(),
            'isItem' => $this->item->getType() === Type::ITEM,
            'isPermgroup' => $this->item->getType() === Type::PERMGROUP,
            'image' => Image::assetPathOrDefault($this->item->getImage())
        ];
    }
}
