<?php
declare(strict_types = 1);

namespace App\Exceptions\Distributor;

use App\Exceptions\DomainException;

class DoesNotExistsException extends DomainException
{
    public function __construct($distributor)
    {
        parent::__construct("Distributor {$distributor} does not exist", 0, null);
    }
}
