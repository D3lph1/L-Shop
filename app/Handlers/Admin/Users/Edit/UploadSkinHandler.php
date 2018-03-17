<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\Entity\User;
use App\Exceptions\Media\Character\InvalidRatioException;
use App\Exceptions\User\DoesNotExistException;
use App\Repository\User\UserRepository;
use App\Services\Media\Character\Skin\Image as SkinImage;
use App\Services\Validation\SkinValidator;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class UploadSkinHandler
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
     * @var SkinValidator
     */
    private $validator;

    public function __construct(UserRepository $userRepository, ImageManager $imageManager, SkinValidator $validator)
    {
        $this->userRepository = $userRepository;
        $this->imageManager = $imageManager;
        $this->validator = $validator;
    }

    public function handle(int $userId, UploadedFile $file): void
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw new DoesNotExistException($userId);
        }

        $image = $this->imageManager->make($file);
        if (!$this->validator->validate($image->width(), $image->height())) {
            throw new InvalidRatioException($image->width(), $image->height());
        }

        $this->move($user, $image);
    }

    /**
     * @param User $user
     * @param Image  $image
     */
    private function move(User $user, Image $image): void
    {
        $image->save(SkinImage::getAbsolutePath($user->getUsername()));
    }
}
