<?php
declare(strict_types = 1);

namespace App\Services;

use App\Models\Ban\BanInterface;
use App\Models\User\UserInterface;
use App\Repositories\Ban\BanRepositoryInterface;
use App\Services\Support\Time;
use Carbon\Carbon;

/**
 * Class Ban
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services
 */
class Ban
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var BanRepositoryInterface
     */
    protected $repository;

    public function __construct(BanRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check if the current user is blocked.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function isBanned(UserInterface $user)
    {
        return $this->repository->isBanned($user);
    }

    /**
     * Blocks the user until a certain date.
     *
     * @param UserInterface $user   User you want to block.
     * @param Carbon|null   $until  Time to which the user will be blocked.
     * @param string|null   $reason Reason for blocking.
     *
     * @return BanInterface
     */
    public function until(UserInterface $user, ?Carbon $until, ?string $reason = null): BanInterface
    {
        $this->pardon($user);

        return $this->repository->create(
            (new \App\DataTransferObjects\Ban())
                ->setUserId($user->getId())
                ->setUntil($until)
                ->setReason($reason)
        );
    }

    /**
     * Block user for a certain number of days.
     *
     * @param UserInterface $user   User you want to block.
     * @param int           $days   Term of blocking.
     * @param string        $reason Reason for blocking.
     *
     * @return \App\Repositories\Ban
     */
    public function forDays(UserInterface $user, int $days, ?string $reason = null): BanInterface
    {
        $until = Time::nowAddInterval($days * 60 * 24);

        return $this->until($user, $until, $reason);
    }

    /**
     * Blocks the user forever.
     *
     * @param UserInterface $user   User you want to block.
     * @param string        $reason Reason for blocking.
     *
     * @return BanInterface
     */
    public function permanently(UserInterface $user, ?string $reason = null): BanInterface
    {
        return $this->until($user, null, $reason);
    }

    /**
     * Unblock given user.
     */
    public function pardon(UserInterface $user): bool
    {
        return $this->repository->deleteByUser($user);
    }

    /**
     * Get ban by user.
     */
    public function get(UserInterface $user): BanInterface
    {
        return $this->repository->findByUser($user);
    }
}
