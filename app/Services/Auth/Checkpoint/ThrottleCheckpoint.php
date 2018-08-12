<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;
use App\Repository\Throttle\ThrottleRepository;
use App\Services\Auth\Exceptions\ThrottlingException;
use App\Services\Auth\ThrottlingManager;

class ThrottleCheckpoint implements Checkpoint
{
    public const NAME = 'throttle';

    /**
     * @var ThrottleRepository
     */
    private $repository;

    /**
     * @var ThrottlingManager
     */
    private $manager;

    /**
     * @var string
     */
    private $ip;

    public function __construct(ThrottleRepository $repository, ThrottlingManager $manager, string $ip)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->ip = $ip;
    }

    /**
     * @inheritDoc
     */
    public function login(User $user): bool
    {
        $this->checkThrottling($user);

        return true;
    }

    /**
     * @inheritDoc
     */
    public function check(User $user): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function loginFail(?User $user = null): void
    {
        $this->checkThrottling($user);

        $this->log();
        if ($user !== null) {
            $this->manager->logUser($user);
        }
    }

    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return self::NAME;
    }

    private function log(): void
    {
        $this->manager->logGlobal();
        $this->manager->logIp($this->ip);
    }

    /**
     * @param User|null $user
     *
     * @throws ThrottlingException
     */
    private function checkThrottling(?User $user = null): void
    {
        $this->manager->throwIfBanned($this->ip, $user);
    }
}
