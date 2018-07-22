<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Add;

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
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'image' => Image::assetPathOrDefault($this->item->getImage()),
            'type' => [
                'isItem' => $this->item->getType() === Type::ITEM,
                'isPermgroup' => $this->item->getType() === Type::PERMGROUP,
                'isCurrency' => $this->item->getType() === Type::CURRENCY,
                'isRegionOwner' => $this->item->getType() === Type::REGION_OWNER,
                'isRegionMember' => $this->item->getType() === Type::REGION_MEMBER,
                'isCommand' => $this->item->getType() === Type::COMMAND,
            ],
            'enchanted' => $this->item->getEnchantmentItems()->count() !== 0
        ];
    }
}
