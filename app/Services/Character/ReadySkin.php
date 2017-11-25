<?php
declare(strict_types = 1);

namespace App\Services\Character;

use Intervention\Image\Image;

/**
 * Class ReadySkin
 * Represents ready-to-work skin element.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Character
 */
class ReadySkin
{
    /**
     * @var null|resource
     */
    private $readySkin = null;

    /**
     * ReadySkin constructor.
     *
     * @param resource $image
     */
    public function __construct($image)
    {
        $this->readySkin = $image;
    }

    public function __destructor()
    {
        if ($this->readySkin != null) {
            imagedestroy($this->readySkin);
        }
    }

    /**
     * Change size of skin or cloak.
     */
    public function resizeImage(int $maxHeight): self
    {
        $height = imagesy($this->readySkin);
        $width = imagesx($this->readySkin);

        $newHeight = $maxHeight;
        $newWidth = ($newHeight * $width) / $height;

        $resize = imagecreatetruecolor($newWidth, $newHeight);
        imagesavealpha($resize, true);
        $transparent = imagecolorallocatealpha($resize, 233, 233, 233, 127);
        imagefill($resize, 0, 0, $transparent);

        imagecopyresized($resize, $this->readySkin, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        imagedestroy($this->readySkin);
        $this->readySkin = $resize;

        return $this;
    }

    /**
     * @return resource Image in .PNG format.
     */
    public function getImage()
    {
        return $this->readySkin;
    }

    public function saveImage(string $path): void
    {
        imagepng($this->readySkin, $path);
    }

    public function saveImageAsTmpAndGet(): Image
    {
        return \Image::make($this->getImage());
    }
}
