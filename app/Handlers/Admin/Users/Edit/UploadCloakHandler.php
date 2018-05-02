<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\Entity\User;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\User\UserNotFoundException;
use App\Repository\User\UserRepository;
use App\Services\Validation\CloakValidator;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use App\Services\Media\Character\Cloak\Image as CloakImage;

class UploadCloakHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var CloakValidator
     */
    private $validator;

    public function __construct(UserRepository $userRepository, ImageManager $imageManager, CloakValidator $validator)
    {
        $this->userRepository = $userRepository;
        $this->imageManager = $imageManager;
        $this->validator = $validator;
    }

    /**
     * @param int          $userId
     * @param UploadedFile $file
     *
     * @throws UserNotFoundException
     */
    public function handle(int $userId, UploadedFile $file): void
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw UserNotFoundException::byId($userId);
        }

        $image = $this->imageManager->make($file);
        if (!$this->validator->validate($image->width(), $image->height())) {
            throw new InvalidRatioException($image->width(), $image->height());
        }

        $this->move($user, $image);
    }

    /**
     * @param User  $user
     * @param Image $image
     */
    private function move(User $user, Image $image): void
    {
        $image->save(CloakImage::getAbsolutePath($user->getUsername()));
    }
}
