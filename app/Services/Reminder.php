<?php

namespace App\Services;

use App\Exceptions\User\NotFoundException;
use App\Exceptions\User\RemindCodeNotFound;
use App\Exceptions\User\UnableToCompleteRemindException;
use App\Mail\ForgotPassword;
use App\Models\Reminder\EloquentReminder;
use App\Models\User\UserInterface;
use Cartalyst\Sentinel\Sentinel;

/**
 * Class Reminder
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Reminder
{
    private $sentinel;

    public function __construct(Sentinel $sentinel)
    {
        $this->sentinel = $sentinel;
    }

    /**
     * @param string $email User email address
     * @param string $ip    User ip address
     */
    public function forgot($email, $ip)
    {
        $user = $this->user($email);
        $reminder = \Reminder::create($user);

        $this->sendEmail($user, $reminder, $ip);
    }

    /**
     * @param int    $userId
     * @param string $code
     * @param string $password
     *
     * @return bool
     */
    public function reset($userId, $code, $password)
    {
        if (!$this->checkCode($userId, $code)) {
            throw new RemindCodeNotFound();
        }

        if (!$this->complete($userId, $code, $password)) {
            throw new UnableToCompleteRemindException();
        }
    }

    /**
     * @param int    $userId User identifier.
     * @param string $code   Code for reset password.
     *
     * @return bool
     */
    public function checkCode($userId, $code)
    {
        $user = $this->sentinel->getUserRepository()->findById($userId);

        return \Reminder::exists($user, $code);
    }

    /**
     * Complete the password recovery.
     *
     * @param int    $userId   User identifier.
     * @param string $code     Code for reset password.
     * @param string $password New password.
     *
     * @return bool
     */
    private function complete($userId, $code, $password)
    {
        $user = $this->sentinel->getUserRepository()->findById($userId);

        return \Reminder::complete($user, $code, $password);
    }

    /**
     * Get user by email.
     */
    private function user(string $email): UserInterface
    {
        /** @var UserInterface $user */
        $user = $this->sentinel->getUserRepository()->findByEmail($email, ['id', 'username', 'email']);

        if (is_null($user)) {
            throw new NotFoundException($email);
        }

        return $user;
    }

    /**
     * Send email for password reset.
     */
    private function sendEmail(UserInterface $user, EloquentReminder $reminder, string $ip)
    {
        \Mail::to($user->getEmail())->queue(new ForgotPassword($user->getId(), $user->getUsername(), $reminder->getCode(), $ip));
    }
}
