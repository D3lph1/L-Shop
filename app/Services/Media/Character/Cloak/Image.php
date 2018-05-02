<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak;

/**
 * Class Image
 * Keeps the interaction logic with the image files of the cloaks.
 */
class Image
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Returns the absolute path to the image of the cloak for the given username,
     * if it exists. Otherwise, returns null.
     * If the parameter is null, returns the path to the directory where the cloaks
     * are stored.
     *
     * @param null|string $username
     *
     * @return null|string
     */
    public static function absolutePath(?string $username = null): ?string
    {
        if ($username === null) {
            return public_path("img/shop/users/cloaks");
        }

        $path = self::filename(self::absolutePath(), $username);

        return file_exists($path) && is_readable($path) ? $path : null;
    }

    /**
     * Returns the absolute path to the cloak image for the given username.
     *
     * @param string $username
     *
     * @return string
     */
    public static function getAbsolutePath(string $username): string
    {
        return self::filename(self::absolutePath(), $username);
    }

    /**
     * Returns the asset path to the image of the cloak for the given username, if it
     * exists. Otherwise, returns null.
     * If the parameter is null, returns the path to the directory where the cloaks
     * are stored.
     *
     * @param null|string $username
     *
     * @return null|string
     */
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

    /**
     * Returns the asset path to the cloak image for the given username.
     *
     * @param string $username
     *
     * @return string
     */
    public static function getAssetPath(string $username): string
    {
        return self::filename(self::assetPath(), $username);
    }

    /**
     * Checks whether the player with given username has a cloak.
     *
     * @param string $username
     *
     * @return bool
     */
    public static function exists(string $username): bool
    {
        return self::absolutePath($username) !== null;
    }

    private static function filename(string $path, string $username): string
    {
        return $path . "/{$username}.png";
    }
}
