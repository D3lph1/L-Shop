<?php
declare(strict_types = 1);

namespace App\Services\Character;

use App\Exceptions\RuntimeException;
use App\Exceptions\User\Character\InvalidImageSizeException;

/**
 * Class Skin
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Character
 */
class Skin
{
    /**
     * @var null|resource
     */
    private $skin = null;

    /**
     * @var null|resource
     */
    private $cloak = null;

    /**
     * @var int Aspect ratio of the skin image.
     */
    private $skinRatio = 1;

    /**
     * @var int Aspect ratio of the cloak image.
     */
    private $cloakRatio = 1;

    /**
     * Skin constructor.
     *
     * @param string $player
     */
    public function __construct(string $player)
    {
        $skinPath = self::getSkinPath($player);
        if (!$skinPath) {
            $skinPath = $local = config('l-shop.profile.skins.default');
        }
        $cloakPath = self::getCloakPath($player);

        $this->loadSkin($skinPath);
        if ($cloakPath) {
            $this->loadCloak($cloakPath);
        }
    }

    public function __destructor()
    {
        if (!is_null($this->skin)) {
            imagedestroy($this->skin);
        }
        if (!is_null($this->cloak)) {
            imagedestroy($this->cloak);
        }
    }

    /**
     * Load new skin.
     *
     * @param string $file Path or URL to the cloak.
     */
    public function loadSkin(string $file): void
    {
        if (!is_null($this->skin)) {
            imagedestroy($this->skin);
        }

        if (($this->skin = imagecreatefrompng($file)) === false) {
            throw new RuntimeException("Unable to load skin");
        }
        if (!$this->validSkin()) {
            throw new InvalidImageSizeException("Invalid skin format");
        }
    }

    /**
     * Load new cloak.
     *
     * @param string $file Path or URL to the cloak.
     */
    public function loadCloak(string $file): void
    {
        if (!is_null($this->cloak)) {
            imagedestroy($this->cloak);
        }

        if (($this->cloak = imagecreatefrompng($file)) === false) {
            throw new RuntimeException("Unable to load cloak");
        }

        if (!$this->validCloak()) {
            throw new InvalidImageSizeException("Invalid cloak format");
        }
    }

    /**
     * Return image width.
     *
     * @param resource $image Image.
     *
     * @return int Image width in pixels.
     */
    private function width($image): int
    {
        if (!is_null($image)) {
            return imagesx($image);
        }

        throw new RuntimeException("File not load");
    }

    /**
     * Return image height.
     *
     * @param resource $image Image.
     *
     * @return int Image height in pixels.
     */
    private function height($image): int
    {
        if ($image != null) {
            return imagesy($image);
        }

        throw new RuntimeException("File not load");
    }

    /**
     * Checks whether the skin is valid.
     */
    protected function validSkin(): bool
    {
        $this->skinRatio = (int)($this->width($this->skin) / 64);

        $validWidth = $this->width($this->skin) / $this->skinRatio === 64;
        $validHeight = $this->height($this->skin) / $this->skinRatio === 32;

        return ($validWidth && $validHeight) ? true : false;
    }

    /**
     * Checks whether the cloak is valid.
     */
    protected function validCloak(): bool
    {
        $this->cloakRatio = (int)($this->width($this->cloak) / 64);

        $validWidth = 0;
        $validHeight = 0;

        if ($this->cloakRatio != 0) {
            $validWidth = $this->width($this->cloak) / $this->cloakRatio === 64;
            $validHeight = $this->height($this->cloak) / $this->cloakRatio === 32;
        }

        if (!($validWidth && $validHeight)) {
            $this->cloakRatio = (int)($this->width($this->cloak) / 17);

            $validWidth = $this->width($this->cloak) / $this->cloakRatio === 22;
            $validHeight = $this->height($this->cloak) / $this->cloakRatio === 17;
        }

        return ($validWidth && $validHeight) ? true : false;
    }

    private function getBackground($width, $height, $ratio, $transparent = true, $r = 233, $g = 233, $b = 233)
    {
        $image = imagecreatetruecolor($width * $ratio, $height * $ratio);
        $background = imagecolorallocate($image, $r, $g, $b);
        imagefilledrectangle($image, 0, 0, $width * $ratio, $height * $ratio, $background);

        if ($transparent) {
            imageColorTransparent($image, $background);
        }

        return $image;
    }

    /**
     * Builds the front of the head.
     */
    public function getFrontHead(): ReadySkin
    {
        $newImage = $this->getBackground(8, 8, $this->skinRatio);

        // Face
        imagecopy($newImage, $this->skin, 0, 0, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        // Area around the head
        $this->imageCopyAlpha($newImage, $this->skin, 0, 0, 40 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the head.
     */
    public function getBackHead(): ReadySkin
    {
        $newImage = $this->getBackground(8, 8, $this->skinRatio);

        // Face
        imagecopy($newImage, $this->skin, 0, 0, 24 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        // Area around the head
        $this->imageCopyAlpha($newImage, $this->skin, 0, 0, 56 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));

        return new ReadySkin($newImage);
    }

    /**
     * Builds the front of the skin.
     */
    public function getFrontSkin(): ReadySkin
    {
        $newImage = $this->getBackground(16, 32, $this->skinRatio);

        // Face
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 0, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        // Area around the head
        $this->imageCopyAlpha($newImage, $this->skin, 4 * $this->skinRatio, 0, 40 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));
        // Body
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 8 * $this->skinRatio, 20 * $this->skinRatio, 20 * $this->skinRatio, 8 * $this->skinRatio, 12 * $this->skinRatio);
        // Legs
        imagecopyresampled($newImage, $this->skin, 8 * $this->skinRatio, 20 * $this->skinRatio, (4 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        // Arms
        imagecopyresampled($newImage, $this->skin, 12 * $this->skinRatio, 8 * $this->skinRatio, (44 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopy($newImage, $this->skin, 0, 8 * $this->skinRatio, 44 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the skin.
     */
    public function getBackSkin(): ReadySkin
    {
        $newImage = $this->getBackground(16, 32, $this->skinRatio);

        // Face
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 0, 24 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        // Area around the head
        $this->imageCopyAlpha($newImage, $this->skin, 4 * $this->skinRatio, 0, 56 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));
        // Body
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 8 * $this->skinRatio, 32 * $this->skinRatio, 20 * $this->skinRatio, 8 * $this->skinRatio, 12 * $this->skinRatio);
        // Legs
        imagecopy($newImage, $this->skin, 8 * $this->skinRatio, 20 * $this->skinRatio, 12 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopyresampled($newImage, $this->skin, 4 * $this->skinRatio, 20 * $this->skinRatio, (12 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        // Arms
        imagecopy($newImage, $this->skin, 12 * $this->skinRatio, 8 * $this->skinRatio, 52 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopyresampled($newImage, $this->skin, 0 * $this->skinRatio, 8 * $this->skinRatio, (52 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the front of the cloak.
     */
    public function getFrontCloak(): ?ReadySkin
    {
        if (is_null($this->cloak)) {
            return null;
        }

        $newImage = $this->getBackground(10, 16, $this->cloakRatio);

        imagecopy($newImage, $this->cloak, 0, 0, 12 * $this->cloakRatio, 1 * $this->cloakRatio, 10 * $this->cloakRatio, 16 * $this->cloakRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the cloak.
     */
    public function getBackCloak(): ?ReadySkin
    {
        if (is_null($this->cloak)) {
            return null;
        }

        $newImage = $this->getBackground(10, 16, $this->cloakRatio);

        imagecopy($newImage, $this->cloak, 0, 0, 1 * $this->cloakRatio, 1 * $this->cloakRatio, 10 * $this->cloakRatio, 16 * $this->cloakRatio);

        return new ReadySkin($newImage);
    }


    private function imageCopyAlpha($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $w, $h, $bg): void
    {
        for ($i = 0; $i < $w; $i++) {
            for ($j = 0; $j < $h; $j++) {
                $rgb = imagecolorat($src, $src_x + $i, $src_y + $j);

                if (($rgb & 0xFFFFFF) === ($bg & 0xFFFFFF)) {
                    $alpha = 127;
                } else {
                    $colors = imagecolorsforindex($src, $rgb);
                    $alpha = $colors["alpha"];
                }
                imagecopymerge($dst, $src, $dst_x + $i, $dst_y + $j, $src_x + $i, $src_y + $j, 1, 1, 100 - (($alpha / 127) * 100));
            }
        }
    }

    /**
     * Return path to player skin.
     *
     * @param string $player Player username.
     *
     * @return bool|string Path to skin or null if skin does not exists.
     */
    public static function getSkinPath(string $player): ?string
    {
        $file = config('l-shop.profile.skins.path') . DIRECTORY_SEPARATOR . $player . '.png';

        if (file_exists($file)) {
            return $file;
        }

        return null;
    }

    /**
     * Return path to player cloak.
     *
     * @param string $player Player username.
     *
     * @return null|string Path to cloak or null if cloak does not exists.
     */
    public static function getCloakPath(string $player): ?string
    {
        $file = config('l-shop.profile.cloaks.path') . DIRECTORY_SEPARATOR . $player . '.png';

        if (file_exists($file)) {
            return $file;
        }

        return null;
    }
}
