<?php

namespace App\Services\Support;

use Carbon\Carbon;

/**
 * Class Time
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Support
 */
class Time
{
    /**
     * @param int $minutes
     *
     * @return Carbon
     */
    public static function nowAddInterval($minutes)
    {
        $interval = \DateInterval::createFromDateString("$minutes minutes");

        return Carbon::now()->add($interval);
    }

    /**
     * @param int $minutes
     *
     * @return Carbon
     */
    public static function nowSubInterval($minutes)
    {
        $interval = \DateInterval::createFromDateString("$minutes minutes");

        return Carbon::now()->sub($interval);
    }
}
