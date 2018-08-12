<?php
declare(strict_types = 1);

namespace App\Exceptions\Enchantment;

use App\Exceptions\DomainException;

class EnchantmentNotFoundException extends DomainException
{
    public static function byId(int $id): EnchantmentNotFoundException
    {
        return new EnchantmentNotFoundException("Enchantment with id {$id} not found");
    }
}
