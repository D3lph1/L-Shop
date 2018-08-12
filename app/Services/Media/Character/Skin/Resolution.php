<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Intervention\Image\Image;

/**
 * Class Resolution
 * The class is responsible for verifying the resolution of the image of the skin,
 * then to what type it belongs.
 */
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

    /**
     * Checks is the passed skin image is the standard definition (SD) image.
     *
     * @param Image $image
     *
     * @return bool
     */
    public function isSD(Image $image): bool
    {
        // Contains an array of the form: [[<image width>, <image height>], ...]
        // For example: [[64, 32], [128, 64]]
        $list = $this->settings->get('system.profile.character.skin.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    /**
     * Checks is the passed skin image is the high definition (HD) image.
     *
     * @param Image $image
     *
     * @return bool
     */
    public function isHD(Image $image): bool
    {
        // Contains an array of the form: [[<image width>, <image height>], ...]
        // For example: [[256, 128], [512, 256]]
        $list = $this->settings->get('system.profile.character.skin.hd.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    /**
     * Checks whether the passed skin image belongs to any type
     *
     * @param Image $image
     *
     * @return bool
     */
    public function isAny(Image $image): bool
    {
        return $this->isSD($image) || $this->isHD($image);
    }

    private function pass(Image $image, array $list)
    {
        foreach ($list as $item) {
            // [<image width>, <image height>]
            //       ↑                ↑
            $width = $item[0];
            $height = $item[1];

            // If the image parameters are the same as the received configuration.
            if ($width === $image->width() && $height === $height) {
                return true;
            }
        }

        return false;
    }
}
