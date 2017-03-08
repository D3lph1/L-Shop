<?php

namespace App\Services;

use App\Mail\UserActivation;
use Cartalyst\Sentinel\Users\UserInterface;

class Reminder
{
    /**
     * @param UserInterface $user
     */
    public function createAndSend(UserInterface $user)
    {
        $activation = \Activation::create($user);

        $this->mail($user->id, $user->username, $activation->code);
    }

    /**
     * Send mail with activation link
     *
     * @param int $userId
     * @param string $username
     * @param string $code
     */
    private function mail($userId, $username, $code)
    {
        \Mail::to('mailbogdik@gmail.com')->sendNow(new UserActivation($userId, $username, $code));
    }
}
