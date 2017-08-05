<?php

namespace App\Exceptions\Payment\Interkassa;

use Throwable;

/**
 * Class UnexpectedStatusException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions\Payment\Interkassa
 */
class UnexpectedStatusException extends \RuntimeException
{
    public function __construct($status, $code = 0, Throwable $previous = null)
    {
        $message = "Expected \"success\" invoice status, \"$status\" given";

        parent::__construct($message, $code, $previous);
    }
}
