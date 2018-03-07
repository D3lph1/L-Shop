<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Catalog;

use App\Entity\EnchantmentItem;
use App\Services\Utils\NumberUtil;

class Enchantment implements \JsonSerializable
{
    /**
     * @var EnchantmentItem
     */
    private $enchantmentItem;

    /**
     * Enchantment constructor.
     *
     * @param EnchantmentItem $enchantmentItem
     */
    public function __construct(EnchantmentItem $enchantmentItem)
    {
        $this->enchantmentItem = $enchantmentItem;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => __("enchantments.names.{$this->enchantmentItem->getEnchantment()->getGameId()}"),
            'level' => NumberUtil::toRoman($this->enchantmentItem->getLevel())
        ];
    }
}
