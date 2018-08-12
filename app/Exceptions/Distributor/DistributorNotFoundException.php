<?php
declare(strict_types = 1);

namespace App\Exceptions\Distributor;

use App\Exceptions\DomainException;

class DistributorNotFoundException extends DomainException
{
    public static function byClassName(string $className): DistributorNotFoundException
    {
        return new DistributorNotFoundException("Distributor {$className} not found");
    }
}
