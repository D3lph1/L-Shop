<?php
declare(strict_types = 1);

namespace App\Exceptions\Payer;

use App\Exceptions\DomainException;

class PayerNotFoundException extends DomainException
{
    public static function byName(string $name): PayerNotFoundException
    {
        return new PayerNotFoundException("Payer with name \"{$name}\" not found");
    }
}
