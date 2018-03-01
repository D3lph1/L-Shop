<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

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
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->item->getId(),
            'name' => $this->item->getName(),
            'description' => $this->item->getDescription(),
            'type' => $this->item->getType(),
            'image' => $this->item->getImage(),
            'image_url' => Image::assetPathOrDefault($this->item->getImage()),
            'game_id' => $this->item->getGameId(),
            'extra' => $this->item->getExtra()
        ];
    }
}
