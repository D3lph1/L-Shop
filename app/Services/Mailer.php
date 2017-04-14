<?php

namespace App\Services;

use App\Mail\TestMail;

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
