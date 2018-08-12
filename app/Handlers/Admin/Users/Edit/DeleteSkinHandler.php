<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Edit;

use App\Exceptions\User\UserNotFoundException;
use App\Repository\User\UserRepository;
use App\Services\Media\Character\Skin\Image;
use Illuminate\Filesystem\Filesystem;

class DeleteSkinHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(UserRepository $userRepository, Filesystem $filesystem)
    {
        $this->userRepository = $userRepository;
        $this->filesystem = $filesystem;
    }

    /**
     * @param int $userId
     *
     * @return bool
     * @throws UserNotFoundException
     */
    public function handle(int $userId): bool
    {
        $user = $this->userRepository->find($userId);
        if ($user === null) {
            throw UserNotFoundException::byId($userId);
        }

        if (Image::isDefault($user->getUsername())) {
            return false;
        }

        return $this->filesystem->delete(Image::getAbsolutePath($user->getUsername()));
    }
}
