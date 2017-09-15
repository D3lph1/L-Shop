<?php
declare(strict_types = 1);

namespace App\Services;

class Image
{
    public static function getOrDefault(string $path, string $default): string
    {
        $image = 'img/' . $path;

        if (is_file($image) && file_exists($image)) {
            return asset($image);
        }

        return asset('img/' . $default);
    }
}
