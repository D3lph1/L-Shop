<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\Exceptions\RuntimeException;
use Throwable;

class MonitoringException extends RuntimeException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
