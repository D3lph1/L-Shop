<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\Media\Character\InvalidResolutionException;
use App\Services\Auth\Auth;
use App\Services\Media\Character\Skin\Accessor;
use App\Services\Media\Character\Skin\Image as SkinImage;
use App\Services\Media\Character\Skin\Resolution;
use App\Services\Media\Image as ImageUtil;
use App\Services\Validation\SkinValidator;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadSkinHandler
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var Accessor
     */
    private $accessor;

    /**
     * @var Resolution
     */
    private $resolution;

    /**
     * @var SkinValidator
     */
    private $validator;

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(
        ImageManager $imageManager,
        Accessor $accessor,
        Resolution $resolution,
        SkinValidator $validator,
        Auth $auth)
    {
        $this->imageManager = $imageManager;
        $this->accessor = $accessor;
        $this->resolution = $resolution;
        $this->validator = $validator;
        $this->auth = $auth;
    }

    /**
     * @param UploadedFile $file
     *
     * @throws InvalidRatioException
     * @throws InvalidResolutionException
     * @throws FileException
     * @throws ForbiddenException
     */
    public function handle(UploadedFile $file): void
    {
        $image = $this->imageManager->make($file);
        if ($this->accessor->allowSetHD($this->auth->getUser())) {
            if (!$this->validator->validate($image->width(), $image->height())) {
                throw new InvalidRatioException($image->width(), $image->height());
            }

            if (!$this->resolution->isAny($image)) {
                throw new InvalidResolutionException($image->width(), $image->height());
            }

            $this->move($image);

            return;
        }

        if ($this->accessor->allowSet($this->auth->getUser())) {
            if (!$this->validator->validate($image->width(), $image->height())) {
                throw new InvalidRatioException($image->width(), $image->height());
            }

            if (!$this->resolution->isSD($image)) {
                throw new InvalidResolutionException($image->width(), $image->height());
            }

            $this->move($image);

            return;
        }

        throw new ForbiddenException();
    }

    /**
     * @param Image $image
     *
     * @throws FileException
     */
    private function move(Image $image): void
    {
        $image->save(SkinImage::getAbsolutePath($this->auth->getUser()->getUsername()));
    }
}
