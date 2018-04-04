<?php
declare(strict_types = 1);

namespace App\Services\Item\Enchantment;

use App\Entity\Item;

class Enchantment
{
    public static function isEnchanted(Item $item): bool
    {
        return count($item->getEnchantmentItems()) !== 0;
    }
}
