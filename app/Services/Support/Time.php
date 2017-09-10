<?php
declare(strict_types = 1);

namespace App\Services\Support;

use Carbon\Carbon;

/**
 * Class Time
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Support
 */
class Time
{
    public static function nowAddInterval(int $minutes): Carbon
    {
        $interval = \DateInterval::createFromDateString("$minutes minutes");

        return Carbon::now()->add($interval);
    }

    public static function nowSubInterval(int $minutes): Carbon
    {
        $interval = \DateInterval::createFromDateString("$minutes minutes");

        return Carbon::now()->sub($interval);
    }
}
