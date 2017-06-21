<?php

namespace App\Services\Character;

/**
 * Class Skin
 * @package App\Services\Character
 */
class Skin
{
    private $skin = null;
    private $cloak = null;
    private $skinRatio = 1;
    private $cloakRatio = 1;

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
     * Загружает новый скин
     *
     * @param $file string путь или URL до скина
     *
     * @throws \Exception ошибка в случае если файл не загрузился или скин не прошел проверку
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
     * Загружает новый плащ
     *
     * @param $file string путь или URL до плаща
     *
     * @throws \Exception ошибка в случае если файл не загрузился или плаш не прошел проверку
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
     * Возвращает ширину картинки
     *
     * @param $image resource картинка
     *
     * @return int ширина картинки в пикселях
     * @throws \Exception если картинка не задана
     */
    private function width($image)
    {
        if ($image != null) {
            return imagesx($image);
        }

        throw new \Exception("Файл не загружен.");
    }

    /**
     * Возвращает высоту картинки
     *
     * @param $image resource картинка
     *
     * @return int высота картинки в пикселях
     * @throws \Exception если картинка не задана
     */
    private function height($image)
    {
        if ($image != null) {
            return imagesy($image);
        }

        throw new \Exception("Файл не загружен.");
    }

    /**
     * Проверяет является ли скин валидным
     *
     * @return bool true если скин валидный
     */
    protected function validSkin()
    {
        $this->skinRatio = (int)($this->width($this->skin) / 64);

        $validWidth = $this->width($this->skin) / $this->skinRatio == 64;
        $validHeight = $this->height($this->skin) / $this->skinRatio == 32;

        return ($validWidth && $validHeight) ? true : false;
    }

    /**
     * Проверяет является ли плащ валидным
     *
     * @return bool true если скин валидный
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
     * Строит лицевую часть головы
     *
     * @return ReadySkin объект с готовой головой
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
     * Строит заднюю часть головы
     *
     * @return ReadySkin объект с готовой головой
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
     * Строит лицевую часть скина
     *
     * @return ReadySkin объект с готовым скином
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
     * Строит лицевую часть скина
     *
     * @return ReadySkin объект с готовым скином
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
     * Строит лицевую часть плаща
     *
     * @return ReadySkin|false объект с готовым плащом или false если плаща нет
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
     * Строит заднюю часть плаща
     *
     * @return ReadySkin|false объект с готовым плащом или false если плаща нет
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
     * Возвращает путь до скина игрока
     *
     * @param $player string ник игрока чей скин необходимо показать.
     *
     * @return bool|string ссылка на скин игрока или false если скин не найден
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
     * Возвращает путь до плаща игрока
     *
     * @param $player string ссылка игрока чей плащ необходимо показать.
     *
     * @return bool|string ссылка на скин игрока или false если плащ не найден
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
