<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Admin\Items\EditList;

use App\Entity\Item as Entity;
use App\Services\Item\Image\Image;

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
            'image' => Image::assetPathOrDefault($this->item->getImage()),
            'type' => __("common.item.type.{$this->item->getType()}"),
            'enchanted' => $this->item->getEnchantmentItems()->count() !== 0
        ];
    }
}
