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
    protected static $defaultFormat = 'd-m-Y H:i:s';

    private function __construct()
    {
        //
    }

    /**
     * It convert given datetime to default system format.
     */
    public static function default($datetime): string
    {
        if ($datetime instanceof Carbon) {
            return $datetime->format(static::$defaultFormat);
        }

        return (new Carbon($datetime))->format(static::$defaultFormat);
    }

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
