<?php
declare(strict_types = 1);

namespace App\Services\Item\Image;

class Image
{
    private const PATH = 'img/shop/items';

    private function __construct()
    {
    }

    public static function assetPathOrDefault(?string $image): string
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

    public static function assetPath(?string $name = null): string
    {
        if ($name === null) {
            return asset(self::PATH);
        }
        return self::PATH . '/' . $name;
    }

    public static function absolutePath(?string $name = null): string
    {
        if ($name === null) {
            return public_path(self::PATH);
        }
        return public_path(self::PATH . DIRECTORY_SEPARATOR . $name);
    }
}
