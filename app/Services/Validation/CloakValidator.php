<?php
declare(strict_types = 1);

namespace App\Services\Validation;

class CloakValidator
{
    public function validate(int $width, int $height)
    {
        $ratio = (int)($width / 64);

        $validWidth = 0;
        $validHeight = 0;

        if ($ratio != 0) {
            $validWidth = $width / $ratio === 64;
            $validHeight = $height / $ratio === 32;
        }

        if (!($validWidth && $validHeight)) {
            $ratio = (int)($width / 17);

            $validWidth = $width / $ratio === 22;
            $validHeight = $height / $ratio === 17;
        }

        return $validWidth && $validHeight;
    }
}
