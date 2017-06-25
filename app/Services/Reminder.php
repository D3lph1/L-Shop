<?php

namespace App\Services;

use App\Exceptions\User\RemindCodeNotFound;
use App\Exceptions\User\UnableToCompleteRemindException;
use App\Mail\ForgotPassword;
use App\Exceptions\User\NotFoundException;
use App\Models\User;
use Cartalyst\Sentinel\Users\UserInterface;
use Cartalyst\Sentinel\Reminders\EloquentReminder;

/**
 * Class Reminder
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Reminder
{
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
        $user = \Sentinel::findById($userId);

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
        $user = \Sentinel::findById($userId);

        return \Reminder::complete($user, $code, $password);
    }

    /**
     * Get user by email.
     *
     * @param string $email User email.
     *
     * @throws NotFoundException
     *
     * @return mixed
     */
    private function user($email)
    {
        $user = \Sentinel::findByCredentials(['email' => $email]);

        if (!$user) {
            throw new NotFoundException();
        }

        return $user;
    }

    /**
     * Send email for password reset.
     *
     * @param UserInterface    $user
     * @param EloquentReminder $reminder
     * @param                  $ip
     */
    private function sendEmail(UserInterface $user, EloquentReminder $reminder, $ip)
    {
        /** @var User $user */
        \Mail::to($user->email)->queue(new ForgotPassword($user->id, $user->username, $reminder->code, $ip));
    }
}
