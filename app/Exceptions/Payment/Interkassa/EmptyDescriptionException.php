<?php

namespace App\Exceptions\Payment\Interkassa;

use Throwable;

class EmptyDescriptionException extends \RuntimeException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Invoice description is required and cannot be empty.', $code, $previous);
    }
}
