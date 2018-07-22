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
        $enchantments = [];
        foreach ($this->item->getEnchantmentItems() as $item) {
            $enchantments[] = new Enchantment($item);
        }

        return [
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'description' => $this->item->getDescription(),
            'type' => [
                'isItem' => $this->item->getType() === Type::ITEM,
                'isPermgroup' => $this->item->getType() === Type::PERMGROUP,
                'isCurrency' => $this->item->getType() === Type::CURRENCY,
                'isRegionOwner' => $this->item->getType() === Type::REGION_OWNER,
                'isRegionMember' => $this->item->getType() === Type::REGION_MEMBER,
                'isCommand' => $this->item->getType() === Type::COMMAND,
            ],
            'image' => Image::assetPathOrDefault($this->item->getImage()),
            'enchantments'=> $enchantments
        ];
    }
}
