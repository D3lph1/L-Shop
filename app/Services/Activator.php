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
     * @param UserInterface $user
     */
    public function createAndSend(UserInterface $user)
    {
        $activation = \Activation::create($user);

        /** @var User $user */
        $this->mail($user->id, $user->username, $user->email, $activation->code);
    }

    /**
     * Send mail with activation link
     *
     * @param int    $userId
     * @param string $username
     * @param string $email
     * @param string $code
     */
    private function mail($userId, $username, $email, $code)
    {
        \Mail::to($email)->queue(new UserActivation($userId, $username, $code));
    }
}
