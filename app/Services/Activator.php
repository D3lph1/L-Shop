<?php

namespace App\Services;

use App\Mail\UserActivation;
use App\Models\User;
use Cartalyst\Sentinel\Users\UserInterface;

/**
 * Class Activator
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
class Activator
{
    /**
     * Create new activation and send it in mail to given user.
     *
     * @param UserInterface $user Activation letter recipient.
     */
    public function createAndSend(UserInterface $user): void
    {
        $activation = \Activation::create($user);

        /** @var User $user */
        $this->mail($user->id, $user->username, $user->email, $activation->code);
    }

    /**
     * Send mail with activation link.
     *
     * @param int    $userId   Activation user identifier.
     * @param string $username Activation user username.
     * @param string $email    Activation user email.
     * @param string $code     Activation code.
     */
    private function mail(int $userId, string $username, string $email, string $code): void
    {
        \Mail::to($email)->queue(new UserActivation($userId, $username, $code));
    }
}
