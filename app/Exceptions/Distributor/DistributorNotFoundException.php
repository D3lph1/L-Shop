<?php
declare(strict_types = 1);

namespace App\Exceptions\Distributor;

use App\Exceptions\DomainException;

class DistributorNotFoundException extends DomainException
{
    public static function byId(int $id): DistributorNotFoundException
    {
        return new DistributorNotFoundException("Distributor with id {$id} not found");
    }
}
