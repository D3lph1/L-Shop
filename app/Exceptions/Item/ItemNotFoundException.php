<?php
declare(strict_types = 1);

namespace App\Exceptions\Item;

use App\Exceptions\DomainException;

class ItemNotFoundException extends DomainException
{
    public static function byId(int $id): ItemNotFoundException
    {
        return new ItemNotFoundException("Item with id {$id} not found");
    }
}
