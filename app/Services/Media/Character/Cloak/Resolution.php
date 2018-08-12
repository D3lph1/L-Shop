<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Cloak;

use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Intervention\Image\Image;

/**
 * Class Resolution
 * The class is responsible for verifying the resolution of the image of the cloak,
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
     * Checks is the passed image of the cloak standard definition (SD) image.
     *
     * @param Image $image
     *
     * @return bool
     */
    public function isSD(Image $image): bool
    {
        // Contains an array of the form: [[<image width>, <image height>], ...]
        // For example: [[22, 17]]
        $list = $this->settings->get('system.profile.character.cloak.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    /**
     * Checks is the passed cloak image is the standard definition (SD) image.
     *
     * @param Image $image
     *
     * @return bool
     */
    public function isHD(Image $image): bool
    {
        // Contains an array of the form: [[<image width>, <image height>], ...]
        // For example: [[22, 17]]
        $list = $this->settings->get('system.profile.character.cloak.hd.list')->getValue(DataType::JSON);

        return $this->pass($image, $list);
    }

    /**
     * Checks is the passed cloak image is the high definition (HD) image.
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
