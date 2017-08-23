<?php

namespace App\Exceptions\Payment\Interkassa;

use App\Exceptions\LShopException;
use Throwable;

/**
 * Class EmptyDescriptionException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment\Interkassa
 */
class EmptyDescriptionException extends \RuntimeException implements LShopException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('Invoice description is required and cannot be empty.', $code, $previous);
    }
}
