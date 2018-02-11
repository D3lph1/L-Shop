<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Intervention\Image\Image;

class Resolution
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function isSD(Image $image): bool
    {
        $list = $this->settings->get('system.profile.character.skin.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    public function isHD(Image $image): bool
    {
        $list = $this->settings->get('system.profile.character.skin.hd.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    public function isAny(Image $image): bool
    {
        return $this->isSD($image) || $this->isHD($image);
    }

    private function pass(Image $image, array $list)
    {
        foreach ($list as $item) {
            $width = $item[0];
            $height = $item[1];

            if ($width === $image->width() && $height === $height) {
                return true;
            }
        }

        return false;
    }
}
