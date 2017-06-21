<?php

namespace App\Services;

use App\Exceptions\User\BannedException;
use App\Repositories\BanRepository;
use Carbon\Carbon;
use Cartalyst\Sentinel\Checkpoints\CheckpointInterface;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Class BanCheckpoint
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class BanCheckpoint implements CheckpointInterface
{
    /**
     * @var BanRepository
     */
    protected $repository;

    /**
     * BanCheckpoint constructor.
     *
     * @param BanRepository $repository
     */
    public function __construct(BanRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Checkpoint after a user is logged in. Return false to deny persistence.
     *
     * @param  \Cartalyst\Sentinel\Users\UserInterface $user
     *
     * @return bool
     */
    public function login(UserInterface $user)
    {
        return $this->checkBanStatus($user);
    }

    /**
     * Checkpoint for when a user is currently stored in the session.
     *
     * @param  \Cartalyst\Sentinel\Users\UserInterface $user
     *
     * @return bool
     */
    public function check(UserInterface $user)
    {
        return $this->checkBanStatus($user);
    }

    /**
     * Checkpoint for when a failed login attempt is logged. User is not always
     * passed and the result of the method will not affect anything, as the
     * login failed.
     *
     * @param  \Cartalyst\Sentinel\Users\UserInterface $user
     *
     * @return void
     */
    public function fail(UserInterface $user = null)
    {
        //
    }

    /**
     * @param UserInterface $user
     *
     * @return bool
     */
    protected function checkBanStatus(UserInterface $user)
    {
        $ban = $this->repository->findByUser($user);
        if (!$ban) {
            return true;
        }

        if (is_null($ban->until)) {
            $this->logout();

            throw new BannedException(null, $ban->reason);
        }

        $untilDate = $ban->until;
        $nowDate = new Carbon(Carbon::now());

        if ($untilDate > $nowDate) {
            $this->logout();

            throw new BannedException($untilDate, $ban->reason);
        }

        return true;
    }

    protected function logout()
    {
        \Sentinel::disableCheckpoints();
        \Sentinel::logout();
        \Sentinel::enableCheckpoints();
    }
}
