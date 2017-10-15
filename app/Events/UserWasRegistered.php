<?php
declare(strict_types = 1);

namespace App\Events;

use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Queue\SerializesModels;

/**
 * Class UserWasRegistered
 * Event triggered when a new user is created.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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
    public function __construct(UserInterface $user, bool $needSendActivationMail)
    {
        $this->user = $user;
        $this->needSendActivationMail = $needSendActivationMail;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function isNeedSendActivationMail(): bool
    {
        return $this->needSendActivationMail;
    }
}
