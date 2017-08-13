<?php

namespace App\Services;

use App\Exceptions\User\BannedException;
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
     * @var Ban
     */
    protected $ban;

    /**
     * BanCheckpoint constructor.
     *
     * @param Ban $ban
     */
    public function __construct(Ban $ban)
    {
        $this->ban = $ban;
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
     * Check if the user is blocked.
     *
     * @param UserInterface $user
     *
     * @return bool
     */
    protected function checkBanStatus(UserInterface $user)
    {
        if ($this->ban->isBanned($user)) {
            $ban = $this->ban->get($user);

            throw new BannedException($ban->getUntil(), $ban->getReason());
        }

        return true;
    }

    /**
     * Turns off all checkpoints, de-logs the user, and then turns them back on.
     */
    protected function logout()
    {
        \Sentinel::disableCheckpoints();
        \Sentinel::logout();
        \Sentinel::enableCheckpoints();
    }
}
