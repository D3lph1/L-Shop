<?php
declare(strict_types = 1);

namespace App\Exceptions\Distributor;

use App\Exceptions\LogicException;

class NotAttemptedException extends LogicException
{
    public function __construct(string $distributorClass)
    {
        parent::__construct("Class {$distributorClass} does not implement interface"
            . 'App\Services\Purchasing\Distributors\Attempting so it is impossible to '
            . 'perform direct delivery of goods');
    }
}
