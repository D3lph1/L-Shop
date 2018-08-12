<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\Repository\User\UserRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Hashing\Hasher;

class ChangePasswordHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * @var Hasher
     */
    private $hasher;

    public function __construct(Auth $auth, UserRepository $repository, Hasher $hasher)
    {
        $this->auth = $auth;
        $this->repository = $repository;
        $this->hasher = $hasher;
    }

    public function handle(string $newPassword): void
    {
        $this->repository->update($this->auth->getUser()->setPassword($this->hasher->make($newPassword)));
    }
}
