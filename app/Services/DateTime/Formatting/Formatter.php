<?php
declare(strict_types = 1);

namespace App\Services\DateTime\Formatting;

use DateTimeInterface;

interface Formatter
{
    public function format(DateTimeInterface $dateTime);
}
