<?php

namespace App\Services\Character;

/**
 * Class Skin
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
    public function __construct($player)
    {
        $skinPath = Skin::getSkinPath($player);
        if (!$skinPath) {
            $skinPath = $local = config('l-shop.profile.skins.default');
        }
        $cloakPath = Skin::getCloakPath($player);

        $this->loadSkin($skinPath);
        if ($cloakPath) {
            $this->loadCloak($cloakPath);
        }
    }

    public function __destructor()
    {
        if ($this->skin != null) {
            imagedestroy($this->skin);
        }
        if ($this->cloak != null) {
            imagedestroy($this->cloak);
        }
    }

    /**
     * Load new skin.
     *
     * @param string $file Path or URL to the cloak.
     *
     * @throws \Exception Error in case the file did not boot or the skin failed.
     */
    public function loadSkin($file)
    {
        if ($this->skin != null) {
            imagedestroy($this->skin);
        }


        if (($this->skin = imagecreatefrompng($file)) == false) {
            throw new \Exception("Невозможно загрузить скин.");
        }
        if (!$this->validSkin()) {
            throw new \Exception("Неправильный формат скина.");
        }

    }

    /**
     * Load new cloak.
     *
     * @param string $file Path or URL to the cloak.
     *
     * @throws \Exception Error in case the file did not boot or the cloak failed.
     */
    public function loadCloak($file)
    {
        if ($this->cloak != null) {
            imagedestroy($this->cloak);
        }
        if (($this->cloak = imagecreatefrompng($file)) == false) {
            throw new \Exception("Невозможно загрузить плащ.");
        }
        if (!$this->validCloak()) {
            throw new \Exception("Неправильный формат плаща.");
        }
    }

    /**
     * Return image width.
     *
     * @param resource $image Image.
     *
     * @return int Image width in pixels.
     * @throws \Exception If no picture is specified.
     */
    private function width($image)
    {
        if ($image != null) {
            return imagesx($image);
        }

        throw new \Exception("Файл не загружен.");
    }

    /**
     * Return image height.
     *
     * @param resource $image Image.
     *
     * @return int Image height in pixels.
     * @throws \Exception If no picture is specified.
     */
    private function height($image)
    {
        if ($image != null) {
            return imagesy($image);
        }

        throw new \Exception("Файл не загружен.");
    }

    /**
     * Checks whether the skin is valid.
     *
     * @return bool
     */
    protected function validSkin()
    {
        $this->skinRatio = (int)($this->width($this->skin) / 64);

        $validWidth = $this->width($this->skin) / $this->skinRatio == 64;
        $validHeight = $this->height($this->skin) / $this->skinRatio == 32;

        return ($validWidth && $validHeight) ? true : false;
    }

    /**
     * Checks whether the cloak is valid.
     *
     * @return bool
     */
    protected function validCloak()
    {
        $this->cloakRatio = (int)($this->width($this->cloak) / 64);

        $validWidth = 0;
        $validHeight = 0;

        if ($this->cloakRatio != 0) {
            $validWidth = $this->width($this->cloak) / $this->cloakRatio == 64;
            $validHeight = $this->height($this->cloak) / $this->cloakRatio == 32;
        }

        if (!($validWidth && $validHeight)) {
            $this->cloakRatio = (int)($this->width($this->cloak) / 17);

            $validWidth = $this->width($this->cloak) / $this->cloakRatio == 22;
            $validHeight = $this->height($this->cloak) / $this->cloakRatio == 17;
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
     *
     * @return ReadySkin Object with a ready head.
     */
    public function getFrontHead()
    {
        $newImage = $this->getBackground(8, 8, $this->skinRatio);

        //Лицо
        imagecopy($newImage, $this->skin, 0, 0, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        //Область вокруг головы
        $this->imageCopyAlpha($newImage, $this->skin, 0, 0, 40 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the head.
     *
     * @return ReadySkin Object with a ready head.
     */
    public function getBackHead()
    {
        $newImage = $this->getBackground(8, 8, $this->skinRatio);

        //Лицо
        imagecopy($newImage, $this->skin, 0, 0, 24 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        //Область вокруг головы
        $this->imageCopyAlpha($newImage, $this->skin, 0, 0, 56 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));

        return new ReadySkin($newImage);
    }

    /**
     * Builds the front of the skin.
     *
     * @return ReadySkin Object with a ready skin.
     */
    public function getFrontSkin()
    {
        $newImage = $this->getBackground(16, 32, $this->skinRatio);

        //Лицо
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 0, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        //Область вокруг головы
        $this->imageCopyAlpha($newImage, $this->skin, 4 * $this->skinRatio, 0, 40 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));
        //Туловище
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 8 * $this->skinRatio, 20 * $this->skinRatio, 20 * $this->skinRatio, 8 * $this->skinRatio, 12 * $this->skinRatio);
        //Ноги
        imagecopyresampled($newImage, $this->skin, 8 * $this->skinRatio, 20 * $this->skinRatio, (4 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        //Руки
        imagecopyresampled($newImage, $this->skin, 12 * $this->skinRatio, 8 * $this->skinRatio, (44 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopy($newImage, $this->skin, 0, 8 * $this->skinRatio, 44 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the skin.
     *
     * @return ReadySkin Object with a ready skin.
     */
    public function getBackSkin()
    {
        $newImage = $this->getBackground(16, 32, $this->skinRatio);

        //Лицо
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 0, 24 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio);
        //Область вокруг головы
        $this->imageCopyAlpha($newImage, $this->skin, 4 * $this->skinRatio, 0, 56 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, 8 * $this->skinRatio, imagecolorat($this->skin, 63 * $this->skinRatio, 0));
        //Туловище
        imagecopy($newImage, $this->skin, 4 * $this->skinRatio, 8 * $this->skinRatio, 32 * $this->skinRatio, 20 * $this->skinRatio, 8 * $this->skinRatio, 12 * $this->skinRatio);
        //Ноги
        imagecopy($newImage, $this->skin, 8 * $this->skinRatio, 20 * $this->skinRatio, 12 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopyresampled($newImage, $this->skin, 4 * $this->skinRatio, 20 * $this->skinRatio, (12 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);
        //Руки
        imagecopy($newImage, $this->skin, 12 * $this->skinRatio, 8 * $this->skinRatio, 52 * $this->skinRatio, 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio);
        imagecopyresampled($newImage, $this->skin, 0 * $this->skinRatio, 8 * $this->skinRatio, (52 * $this->skinRatio + 4 * $this->skinRatio - 1), 20 * $this->skinRatio, 4 * $this->skinRatio, 12 * $this->skinRatio, 0 - 4 * $this->skinRatio, 12 * $this->skinRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the front of the cloak.
     *
     * @return ReadySkin|false Object with a ready cloak.
     */
    public function getFrontCloak()
    {
        if ($this->cloak == null) {
            return false;
        }

        $newImage = $this->getBackground(10, 16, $this->cloakRatio);

        imagecopy($newImage, $this->cloak, 0, 0, 12 * $this->cloakRatio, 1 * $this->cloakRatio, 10 * $this->cloakRatio, 16 * $this->cloakRatio);

        return new ReadySkin($newImage);
    }

    /**
     * Builds the back of the cloak.
     *
     * @return ReadySkin|false Object with a ready cloak or false if the cloak does not exists.
     */
    public function getBackCloak()
    {
        if ($this->cloak == null) {
            return false;
        }

        $newImage = $this->getBackground(10, 16, $this->cloakRatio);

        imagecopy($newImage, $this->cloak, 0, 0, 1 * $this->cloakRatio, 1 * $this->cloakRatio, 10 * $this->cloakRatio, 16 * $this->cloakRatio);

        return new ReadySkin($newImage);
    }


    private function imageCopyAlpha($dst, $src, $dst_x, $dst_y, $src_x, $src_y, $w, $h, $bg)
    {
        for ($i = 0; $i < $w; $i++) {
            for ($j = 0; $j < $h; $j++) {
                $rgb = imagecolorat($src, $src_x + $i, $src_y + $j);

                if (($rgb & 0xFFFFFF) == ($bg & 0xFFFFFF)) {
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
     * @return bool|string Path to skin or false if skin does not exists.
     */
    public static function getSkinPath($player)
    {
        $file = config('l-shop.profile.skins.path') . '/' . $player . '.png';

        if (file_exists($file)) {
            return $file;
        }

        return false;
    }

    /**
     * Return path to player cloak.
     *
     * @param string $player Player username.
     *
     * @return bool|string Path to cloak or false if cloak does not exists.
     */
    public static function getCloakPath($player)
    {
        $file = config('l-shop.profile.cloaks.path') . '/' . $player . '.png';

        if (file_exists($file)) {
            return $file;
        }

        return false;
    }
}
