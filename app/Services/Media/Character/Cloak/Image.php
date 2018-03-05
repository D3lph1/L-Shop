<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak;

class Image
{
    private function __construct()
    {
    }

    public static function absolutePath(?string $username = null): ?string
    {
        if ($username === null) {
            return public_path("img/shop/users/cloaks");
        }

        $path = self::filename(self::absolutePath(), $username);

        return file_exists($path) && is_readable($path) ? $path : null;
    }

    public static function getAbsolutePath(string $username): string
    {
        return self::filename(self::absolutePath(), $username);
    }

    public static function assetPath(?string $username = null): ?string
    {
        if ($username === null) {
            return asset("img/shop/users/cloaks");
        }

        $absolutePath = self::filename(self::absolutePath(), $username);
        $assetPath = self::filename(self::assetPath(), $username);

        return file_exists($absolutePath) && is_readable($absolutePath)
            ? $assetPath : null;
    }

    public static function getAssetPath(string $username): string
    {
        return self::filename(self::assetPath(), $username);
    }

    public static function exists(string $username): bool
    {
        return self::absolutePath($username) !== null;
    }

    private static function filename(string $path, string $username): string
    {
        return $path . "/{$username}.png";
    }
}
