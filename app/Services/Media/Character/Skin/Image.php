<?php
declare(strict_types=1);

namespace App\Services\Media\Character\Skin;

/**
 * Class Image
 * Keeps the interaction logic with the image files of the skins.
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
     * Returns the absolute path to the image of the skin for the given username,
     * if it exists. Otherwise, returns null.
     * If the parameter is null, returns the path to the directory where the skins
     * are stored.
     *
     * @param null|string $username
     *
     * @return string
     */
    public static function absolutePath(?string $username = null): string
    {
        if ($username === null) {
            return public_path('img/shop/users/skins');
        }

        $path = self::filename(self::absolutePath(), $username);

        return file_exists($path) && is_readable($path)
            ? $path : public_path("img/shop/users/default.png");
    }

    /**
     * Returns the absolute path to the skin image for the given username.
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
     * Returns the asset path to the image of the skin for the given username, if it
     * exists. Otherwise, returns null.
     * If the parameter is null, returns the path to the directory where the skins
     * are stored.
     *
     * @param null|string $username
     *
     * @return string
     */
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

    /**
     * Returns the asset path to the skin image for the given username.
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
     * Checks whether the skin of the player with the given username is the default skin.
     *
     * @param string $username
     *
     * @return bool
     */
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
