<?php
declare(strict_types = 1);

namespace App\Services\Monitoring;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class MonitoringException
 * An exception is thrown in the event of an error in the receipt or processing of monitoring statics.
 */
class MonitoringException extends RuntimeException
{
    //
}
