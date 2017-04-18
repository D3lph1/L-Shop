<?php

namespace App\Services;

use App\Mail\TestMail;
use App\Mail\UserActivation;
use Cartalyst\Sentinel\Users\UserInterface;

class Mailer
{
    /**
     * @param string $address
     */
    public function sendTest($address)
    {
        \Mail::to($address)->sendNow(new TestMail());
    }
}
