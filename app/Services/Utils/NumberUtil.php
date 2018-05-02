<?php
declare(strict_types=1);

namespace App\Services\Utils;

use App\Exceptions\InvalidArgumentException;

class NumberUtil
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Translates a number from an arabic entry to a roman.
     *
     * @param int $value
     *
     * @return string Number in roman entry.
     */
    public static function toRoman(int $value): string
    {
        if ($value < 0) {
            throw new InvalidArgumentException('$value must be equal or greater than zero');
        }
        $thousands = (int)($value / 1000);
        $value -= $thousands * 1000;
        $result = str_repeat("M", $thousands);
        $table = [
            900 => "CM",
            500 => "D",
            400 => "CD",
            100 => "C",
            90 => "XC",
            50 => "L",
            40 => "XL",
            10 => "X",
            9 => "IX",
            5 => "V",
            4 => "IV",
            1 => "I"
        ];
        while ($value) {
            foreach ($table as $part => $fragment) {
                if ($part <= $value) {
                    break;
                }
            }
            $amount = (int)($value / $part);
            $value -= $part * $amount;
            $result .= str_repeat($fragment, $amount);
        }

        return $result;
    }
}
