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
    public const FORMAT = 'D M d Y H:i:s O';

    /**
     * Creates javascript-friendly date time representation.
     *
     * {@inheritdoc}
     */
    public function format(DateTimeInterface $dateTime): string
    {
        return $dateTime->format(self::FORMAT);
    }
}
