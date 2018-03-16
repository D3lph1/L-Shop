<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;
use App\Services\Auth\BanManager;
use App\Services\Auth\Exceptions\BannedException;

class BanCheckpoint implements Checkpoint
{
    public const NAME = 'ban';

    /**
     * @var BanManager
     */
    private $banManager;

    public function __construct(BanManager $banManager)
    {
        $this->banManager = $banManager;
    }

    public function login(User $user): bool
    {
        if ($this->banManager->isBanned($user)) {
            throw new BannedException($this->banManager->notExpired($user));
        }

        return true;
    }

    public function check(User $user): bool
    {
        if ($this->banManager->isBanned($user)) {
            throw new BannedException($this->banManager->notExpired($user));
        }

        return true;
    }

    public function loginFail(): void
    {
        //
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
