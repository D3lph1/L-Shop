<?php
declare(strict_types = 1);

namespace App\Services\Character;

use App\Exceptions\User\Character\InvalidImageSizeException;
use Illuminate\Http\UploadedFile;

/**
 * Class UploadedSkin
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services\Character
 */
class UploadedSkin
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
     * UploadedSkin constructor.
     *
     * @param UploadedFile $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
        $this->image = \Image::make($file);
    }

    /**
     * Check image size on valid.
     *
     * @param bool $canSetHdSkin
     *
     * @throws InvalidImageSizeException
     * @return bool
     */
    public function validate($canSetHdSkin)
    {
        $height = $this->image->getHeight();
        $width = $this->image->getWidth();
        $ratio = $width / 64;

        $validHeight = $height / $ratio === 32;
        $validWidth = $width / $ratio === 64;

        if ($canSetHdSkin) {
            if ($validHeight && $validWidth && $width <= 1024 && $height <= 512) {
                return true;
            } else {
                throw new InvalidImageSizeException();
            }
        } else {
            if ($validHeight && $validWidth) {
                if ($height === 32 && $width === 64) {
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
     * Move image file in skins directory.
     *
     * @param string $username
     */
    public function move(string $username)
    {
        $this->file->move(config('l-shop.profile.skins.path'), $username . '.png');
    }
}
