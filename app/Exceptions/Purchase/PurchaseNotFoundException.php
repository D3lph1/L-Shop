<?php
declare(strict_types = 1);

namespace App\Exceptions\Purchase;

use App\Exceptions\DomainException;

class PurchaseNotFoundException extends DomainException
{
    public static function byId(int $id): PurchaseNotFoundException
    {
        return new PurchaseNotFoundException("Purchase with id {$id} not found");
    }
}
