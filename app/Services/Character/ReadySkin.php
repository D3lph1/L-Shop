<?php

namespace App\Services\Character;

/**
 * Class ReadySkin
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
     *
     * @param int $maxHeight New image height.
     *
     * @return $this
     */
    public function resizeImage($maxHeight)
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

    /**
     * @param string $path Save image path.
     */
    public function saveImage($path)
    {
        imagepng($this->readySkin, $path);
    }

    /**
     * @return \Intervention\Image\Image
     */
    public function saveImageAsTmpAndGet()
    {
        return \Image::make($this->getImage());
    }
}
