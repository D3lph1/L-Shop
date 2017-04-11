<?php

namespace App\Events;

use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserWasRegistered
{
    use SerializesModels;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var bool
     */
    private $needSendActivationMail;

    /**
     * Create a new event instance.
     *
     * @param UserInterface $user
     * @param bool          $needSendActivationMail
     */
    public function __construct(UserInterface $user, $needSendActivationMail)
    {
        $this->user = $user;
        $this->needSendActivationMail = $needSendActivationMail;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isNeedSendActivationMail()
    {
        return $this->needSendActivationMail;
    }
}
