<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Admin\Items;

use App\Entity\Item as Entity;
use App\Services\Media\Image;

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
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'image' => Image::itemImagePath($this->item->getImage()),
            'type' => __("common.item.type.{$this->item->getType()}")
        ];
    }
}
