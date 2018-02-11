<?php
declare(strict_types = 1);

namespace App\Services\Validation;

class SkinValidator
{
    public function validate(int $width, int $height): bool
    {
        $ratio = (int)($width / 64);

        $validWidth = $width / $ratio === 64;
        $validHeight = $height / $ratio === 32;

        return $validWidth && $validHeight;
    }
}
