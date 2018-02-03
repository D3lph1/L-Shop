<?php
declare(strict_types = 1);

namespace App\Services\Media;

class Image
{
    private function __construct()
    {
    }

    public static function itemImagePath(?string $image): string
    {
        $default = asset('img/shop/items/default.png');
        if (empty($image)) {
            return $default;
        }

        $path = public_path("img/shop/items/{$image}");

        if (file_exists($path) && is_file($path)) {
            return asset("img/shop/items/{$image}");
        }

        return $default;
    }
}
