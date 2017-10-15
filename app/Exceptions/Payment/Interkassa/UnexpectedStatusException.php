<?php
declare(strict_types = 1);

namespace App\Exceptions\Payment\Interkassa;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class UnexpectedStatusException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment\Interkassa
 */
class UnexpectedStatusException extends RuntimeException
{
    public function __construct(string $status, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Expected \"success\" invoice status, \"$status\" given", $code, $previous);
    }
}
