<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\Edit;

use App\Entity\Enchantment as Entity;
use App\Entity\EnchantmentItem;
use JsonSerializable;

class Enchantment implements JsonSerializable
{
    /**
     * @var Entity
     */
    private $enchantment;

    /**
     * @var EnchantmentItem|null
     */
    private $enchantmentItem;

    public function __construct(Entity $enchantment, ?EnchantmentItem $enchantmentItem = null)
    {
        $this->enchantment = $enchantment;
        $this->enchantmentItem = $enchantmentItem;
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
            'model' => $this->enchantmentItem !== null ? $this->enchantmentItem->getLevel() : 0,
        ];
    }
}
