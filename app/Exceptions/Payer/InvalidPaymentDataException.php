<?php
declare(strict_types = 1);

namespace App\Exceptions\Payer;

use App\Exceptions\RuntimeException;

class InvalidPaymentDataException extends RuntimeException
{
    public function __construct(array $data)
    {
        $json = json_encode($data);
        parent::__construct("Payment data {$json} is invalid", 0, null);
    }
}
