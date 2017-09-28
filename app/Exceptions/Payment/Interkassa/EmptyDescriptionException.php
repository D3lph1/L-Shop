<?php
declare(strict_types = 1);

namespace App\Exceptions\Payment\Interkassa;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class EmptyDescriptionException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment\Interkassa
 */
class EmptyDescriptionException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct('Invoice description is required and cannot be empty.', $code, $previous);
    }
}
