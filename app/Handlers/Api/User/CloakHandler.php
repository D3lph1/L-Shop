<?php
declare(strict_types = 1);

namespace App\Handlers\Api\User;

use App\Repository\User\UserRepository;
use App\Services\Auth\Exceptions\UserDoesNotExistException;
use App\Services\Media\Character\Cloak\Applicators\Applicator;
use App\Services\Media\Character\Cloak\Builder;
use App\Services\Media\Image as ImageUtil;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class CloakHandler
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(ImageManager $imageManager, UserRepository $userRepository)
    {
        $this->imageManager = $imageManager;
        $this->userRepository = $userRepository;
    }

    public function front(string $username): Image
    {
        $this->checkUser($username);
        $canvas = $this->imageManager->make(ImageUtil::cloakPath($username));

        return $this->builder($canvas)->front(256);
    }

    public function back(string $username): Image
    {
        $this->checkUser($username);
        $canvas = $this->imageManager->make(ImageUtil::cloakPath($username));

        return $this->builder($canvas)->back(256);
    }

    private function checkUser(string $username)
    {
        if ($this->userRepository->findByUsername($username) === null) {
            throw new UserDoesNotExistException($username);
        }
    }

    private function builder(Image $canvas)
    {
        return new Builder($this->imageManager, app(Applicator::class, [
            'canvas' => $canvas
        ]));
    }
}
