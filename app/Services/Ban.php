<?php

namespace App\Services;

use App\Repositories\BanRepository;
use App\Services\Support\Time;
use Carbon\Carbon;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Class Ban
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Ban
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var BanRepository
     */
    protected $repository;

    /**
     * Ban constructor.
     *
     * @param BanRepository $repository
     */
    public function __construct(BanRepository $repository)
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
     * @param UserInterface $user
     * @param Carbon|null   $until
     * @param string        $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function until(UserInterface $user, $until, $reason = null)
    {
        $this->pardon($user);

        return $this->repository->create([
            'user_id' => $user->getUserId(),
            'until' => $until,
            'reason' => $reason
        ]);
    }

    /**
     * Block user for a certain number of days.
     *
     * @param UserInterface $user
     * @param int           $days   Term of blocking.
     * @param string        $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function forDays(UserInterface $user, $days, $reason = null)
    {
        $until = Time::nowAddInterval($days * 60 * 24);

        return $this->until($user, $until, $reason);
    }

    /**
     * Blocks the user forever.
     *
     * @param UserInterface $user
     * @param string        $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function permanently(UserInterface $user, $reason)
    {
        return $this->until($user, null, $reason);
    }

    /**
     * Unblock given user.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    public function pardon(UserInterface $user)
    {
        return $this->repository->deleteByUser($user);
    }

    /**
     * @param UserInterface $user
     *
     * @return \App\Models\Ban
     */
    public function get(UserInterface $user)
    {
        return $this->repository->findByUser($user);
    }
}
