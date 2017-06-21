<?php

namespace App\Services\Character;

use App\Exceptions\User\Character\InvalidImageSizeException;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadedCloak
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Character
 */
class UploadedCloak
{
    /**
     * @var UploadedFile
     */
    protected $file;

    /**
     * @var \Intervention\Image\Image
     */
    protected $image;

    /**
     * Check image size on valid.
     *
     * UploadedSkin constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->image = \Image::make($file);
    }

    public function validate($canSetHdCloak)
    {
        $height = $this->image->getHeight();
        $width = $this->image->getWidth();
        $ratio = $width / 64;

        $validHeight = $height / $ratio === 32;
        $validWidth = $width / $ratio === 64;

        if (!($validHeight && $validWidth)) {
            $ratio = $height / 17;

            $validHeight = $width / $ratio == 22;
            $validWidth = $height / $ratio == 17;
        }

        if ($canSetHdCloak) {
            if ($validHeight && $validWidth && $width <= 1024 && $height <= 512) {
                return true;
            } else {
                throw new InvalidImageSizeException();
            }
        } else {
            if ($validHeight && $validWidth) {
                if ($height === 17 && $width === 22) {
                    return true;
                } else {
                    throw new InvalidImageSizeException();
                }
            } else {
                throw new InvalidImageSizeException();
            }
        }
    }

    /**
     * Move image file in cloaks directory
     *
     * @param string $username
     */
    public function move($username)
    {
        $this->file->move(config('l-shop.profile.cloaks.path'), $username . '.png');
    }
}
