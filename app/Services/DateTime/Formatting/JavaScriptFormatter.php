<?php
declare(strict_types = 1);

namespace App\Services\DateTime\Formatting;

use DateTimeInterface;

/**
 * Class JavaScriptFormatter
 * Format the date to send the received view to javascript, which, in turn,
 * will work with it at its discretion.
 */
class JavaScriptFormatter implements Formatter
{
    /**
     * {@inheritdoc}
     */
    public function format(DateTimeInterface $dateTime): string
    {
        return $dateTime->format('D M d Y H:i:s O');
    }
}
