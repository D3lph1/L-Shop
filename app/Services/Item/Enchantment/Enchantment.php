<?php
declare(strict_types = 1);

namespace App\Services\Item\Enchantment;

use App\Entity\Item;

/**
 * Class Enchantment
 * Keeps the service methods for working with enchantments.
 */
class Enchantment
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Checks whether the given item is enchanted
     *
     * @param Item $item
     *
     * @return bool True - item is enchanted.
     */
    public static function isEnchanted(Item $item): bool
    {
        return count($item->getEnchantmentItems()) !== 0;
    }
}
