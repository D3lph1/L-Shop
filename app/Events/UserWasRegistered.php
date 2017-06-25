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

/**
 * Class UserWasRegistered
 * Event triggered when a new user is created.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Events
 */
class UserWasRegistered
{
    use SerializesModels;

    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var bool If true, then a user will receive a confirmation e-mail when a mailing address is specified.
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
