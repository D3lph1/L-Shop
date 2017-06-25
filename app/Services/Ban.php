<?php

namespace App\Services;

use App\Exceptions\InvalidArgumentTypeException;
use App\Repositories\BanRepository;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
     * @var null|\App\Models\Ban
     */
    protected $ban = null;

    /**
     * Ban constructor.
     *
     * @param UserInterface $user The user under which the operations of blocking, unlocking, checking and so on will
     *                            occur.
     * @param BanRepository $repository
     */
    public function __construct(UserInterface $user, BanRepository $repository)
    {
        $this->user = $user;
        $this->repository = $repository;
    }

    /**
     * Check if the current user is blocked.
     *
     * @return bool
     */
    public function isBanned()
    {
        $ban = $this->getBan();
        if (is_null($ban)) {
            return false;
        }

        $until = $ban->until;
        if (is_null($until)) {
            return true;
        }
        $now = Carbon::now();

        return $until > $now ? true : false;
    }

    /**
     * Block user for a certain number of days.
     *
     * @param int    $days   Term of blocking.
     * @param string $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function banForDays($days, $reason)
    {
        if ($days) {
            $date = Carbon::now()->addDay($days);
        } else {
            $date = null;
        }

        return $this->banUntil($date, $reason);
    }

    /**
     * Blocks the user until a certain date.
     *
     * @param null|Carbon $date
     * @param string      $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function banUntil($date, $reason)
    {
        $this->repository->deleteByUser($this->user);

        return $this->repository->create([
            'user_id' => $this->user->getUserId(),
            'until' => $date ? $date->toDateTimeString() : null,
            'reason' => $reason
        ]);
    }

    /**
     * Blocks the user forever.
     *
     * @param string $reason Reason for blocking.
     *
     * @return \App\Models\Ban
     */
    public function banPermanently($reason)
    {
        return $this->banUntil(null, $reason);
    }

    /**
     * Set ban model.
     *
     * @param $ban
     */
    public function setBan($ban)
    {
        if (is_null($ban)) {
            return;
        }

        if (!($ban instanceof \App\Models\Ban)) {
            throw new InvalidArgumentTypeException('\App\Models\Ban', $ban);
        }

        if ($ban->user_id !== $this->user->getUserId()) {
            throw new \InvalidArgumentException(
                sprintf(
                    "This ban belongs to the user with id %d, and not to the user with id %d",
                    $ban->user_id,
                    $this->user->getUserId()
                )
            );
        }

        $this->ban = $ban;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return \App\Models\Ban
     */
    public function getBan()
    {
        if (is_null($this->ban)) {
            $this->ban = $this->repository->findByUser($this->user);
        }

        return $this->ban;
    }

    /**
     * Unblock current user.
     *
     * @return bool
     */
    public function unblock()
    {
        return $this->repository->deleteByUser($this->user);
    }
}
