<?php
declare(strict_types = 1);

namespace App\Services\DateTime\Formatting;

use DateTimeInterface;

class JavaScriptFormatter implements Formatter
{
    public function format(DateTimeInterface $dateTime)
    {
        return $dateTime->format('D M d Y H:i:s O');
    }
}
