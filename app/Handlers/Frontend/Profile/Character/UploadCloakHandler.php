<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Exceptions\ForbiddenException;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\Media\Character\InvalidResolutionException;
use App\Services\Auth\Auth;
use App\Services\Media\Character\Cloak\Accessor;
use App\Services\Media\Character\Cloak\Image as CloakImage;
use App\Services\Media\Character\Cloak\Resolution;
use App\Services\Media\Image as ImageUtil;
use App\Services\Validation\CloakValidator;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadCloakHandler
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
     * @var CloakValidator
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
        CloakValidator $validator,
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
    public function handle(UploadedFile $file)
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
    private function move(Image $image)
    {
        $image->save(CloakImage::getAbsolutePath($this->auth->getUser()->getUsername()));
    }
}
