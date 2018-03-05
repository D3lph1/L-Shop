<?php
declare(strict_types=1);

namespace App\Services\Media\Character\Skin;

class Image
{
    private function __construct()
    {
    }

    public static function absolutePath(?string $username = null): string
    {
        if ($username === null) {
            return public_path('img/shop/users/skins');
        }

        $path = self::filename(self::absolutePath(), $username);

        return file_exists($path) && is_readable($path)
            ? $path : public_path("img/shop/users/default.png");
    }

    public static function getAbsolutePath(string $username): string
    {
        return self::filename(self::absolutePath(), $username);
    }

    public static function assetPath(?string $username = null): string
    {
        if ($username === null) {
            return asset('img/shop/users/skins');
        }

        $assetPath = self::filename(self::assetPath(), $username);
        $absolutePath = self::filename(self::absolutePath(), $username);

        return file_exists($absolutePath) && is_readable($absolutePath)
            ? $assetPath : asset("img/shop/users/default.png");
    }

    public static function getAssetPath(string $username): string
    {
        return self::filename(self::assetPath(), $username);
    }

    public static function isDefault(string $username): bool
    {
        $path = self::filename(self::absolutePath(), $username);

        return !(file_exists($path) && is_readable($path));
    }

    private static function filename(string $path, string $username)
    {
        return $path . "/{$username}.png";
    }
}
