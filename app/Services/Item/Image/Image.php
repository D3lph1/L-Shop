<?php
declare(strict_types = 1);

namespace App\Services\Item\Image;

/**
 * Class Image
 * Keeps methods for working with images of items.
 */
class Image
{
    private const PATH = 'img/shop/items';

    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Gets the asset path to the image file, if one exists. Otherwise - returns the path to the
     * default image. If the argument is null, it returns the path to the default image.
     *
     * @param null|string $image
     *
     * @return string
     */
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

    /**
     * Returns the asset path to the image file. Unlike method {@see Image::assetPathOrDefault()},
     * this will occur even if the file does not exist. If the argument is null, it returns the
     * path to the directory containing the image files.
     *
     * @param null|string $name
     *
     * @return string
     */
    public static function assetPath(?string $name = null): string
    {
        if ($name === null) {
            return asset(self::PATH);
        }
        return self::PATH . '/' . $name;
    }

    /**
     * Returns the absolute path to the image file. Unlike method {@see Image::assetPathOrDefault()},
     * this will occur even if the file does not exist. If the argument is null, it returns the
     * path to the directory containing the image files.
     *
     * @param null|string $name
     *
     * @return string
     */
    public static function absolutePath(?string $name = null): string
    {
        if ($name === null) {
            return public_path(self::PATH);
        }
        return public_path(self::PATH . DIRECTORY_SEPARATOR . $name);
    }
}
