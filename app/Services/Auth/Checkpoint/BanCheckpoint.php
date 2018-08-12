<?php
declare(strict_types = 1);

namespace App\Services\Auth\Checkpoint;

use App\Entity\User;
use App\Services\Auth\BanManager;
use App\Services\Auth\Exceptions\BannedException;

/**
 * Class BanCheckpoint
 * This checkpoint is used to deny access to those users whose account is banned.
 */
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

    /**
     * {@inheritdoc}
     */
    public function login(User $user): bool
    {
        if ($this->banManager->isBanned($user)) {
            throw new BannedException($this->banManager->notExpired($user));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function check(User $user): bool
    {
        if ($this->banManager->isBanned($user)) {
            throw new BannedException($this->banManager->notExpired($user));
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function loginFail(?User $user = null): void
    {
        //
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return self::NAME;
    }
}
