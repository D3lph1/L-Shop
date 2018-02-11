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

    public static function skinPath(string $username): ?string
    {
        $path = public_path("img/shop/users/skins/{$username}.png");

        return file_exists($path) && is_readable($path) ? $path : public_path("img/shop/users/default.png");
    }

    public static function cloakPath(string $username): ?string
    {
        $path = public_path("img/shop/users/cloaks/{$username}.png");

        return file_exists($path) && is_readable($path) ? $path : null;
    }

    public static function getSkinsPath(): string
    {
        return public_path("img/shop/users/skins");
    }

    public static function getSkinsPathWithName(string $username): string
    {
        return public_path("img/shop/users/skins/{$username}.png");
    }

    public static function getCloaksPath(): string
    {
        return public_path("img/shop/users/cloaks");
    }

    public static function getCloaksPathWithName(string $username): string
    {
        return public_path("img/shop/users/cloaks/{$username}.png");
    }

    public static function skinFileName(string $username): string
    {
        return "{$username}.png";
    }

    public static function cloakFileName(string $username): string
    {
        return "{$username}.png";
    }
}
