<?php
declare(strict_types = 1);

namespace App\Exceptions\Distributor;

use App\Exceptions\DomainException;

class DistributionNotFoundException extends DomainException
{
    public static function byId(int $id): DistributionNotFoundException
    {
        return new DistributionNotFoundException("Distribution with id {$id} not found");
    }
}
