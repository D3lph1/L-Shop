<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Add;

use App\Entity\Enchantment as Entity;
use JsonSerializable;

class Enchantment implements JsonSerializable
{
    /**
     * @var Entity
     */
    private $enchantment;

    public function __construct(Entity $enchantment)
    {
        $this->enchantment = $enchantment;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->enchantment->getId(),
            'gameId' => $this->enchantment->getGameId(),
            'name' => __("enchantments.names.{$this->enchantment->getGameId()}"),
            'maxLevel' => $this->enchantment->getMaxLevel(),
            'group' => $this->enchantment->getGroup(),
            'groupName' => __("enchantments.groups.{$this->enchantment->getGroup()}"),
        ];
    }
}
