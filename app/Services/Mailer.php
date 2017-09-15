<?php
declare(strict_types = 1);

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
     * Send mail for test all mail services.
     *
     * @param string $address Email to which the letter will be sent.
     */
    public function sendTest(string $address): void
    {
        \Mail::to($address)->sendNow(new TestMail());
    }
}
