<?php
declare(strict_types = 1);

namespace App\Exceptions;

use Throwable;

/**
 * Class UnexpectedSettingsValueException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions
 */
class UnexpectedSettingsValueException extends UnexpectedValueException
{
    public function __construct(?string $value, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Value '$value' is unexpected", $code, $previous);
    }
}
