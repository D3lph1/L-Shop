<?php
declare(strict_types = 1);

namespace App\Services\DateTime;

use App\Exceptions\InvalidArgumentException;

class DateTimeUtil
{
    private function __construct()
    {
    }

    public static function add(\DateTimeImmutable $dateTime, int $minutes): \DateTimeImmutable
    {
        if ($minutes < 0) {
            throw new InvalidArgumentException('Argument $minutes must be greater or equals 0, ' . $minutes . ' given');
        }
        $interval = \DateInterval::createFromDateString("{$minutes} minutes");

        return $dateTime->add($interval);
    }

    public static function nowAdd(int $minutes): \DateTimeImmutable
    {
        if ($minutes < 0) {
            throw new InvalidArgumentException('Argument $minutes must be greater or equals 0, ' . $minutes . ' given');
        }
        $interval = \DateInterval::createFromDateString("{$minutes} minutes");

        return (new \DateTimeImmutable())->add($interval);
    }

    public static function nowSub(int $minutes): \DateTimeImmutable
    {
        if ($minutes < 0) {
            throw new InvalidArgumentException('Argument $minutes must be greater or equals 0, ' . $minutes . ' given');
        }
        $interval = \DateInterval::createFromDateString("{$minutes} minutes");

        return (new \DateTimeImmutable())->sub($interval);
    }
}
