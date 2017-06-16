<?php

namespace App\Services;

use App\Mail\TestMail;

/**
 * Class Mailer
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Services
 */
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
