<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Other;

use App\Mail\Test;
use Illuminate\Contracts\Mail\Mailer;

class SendTestEmailHandler
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Sends a test email.
     *
     * @param string $address
     *
     * @throws \Exception
     */
    public function handle(string $address): void
    {
        // In order to make sure, at the end or vice versa, a procedure error, the letter
        // is sent immediately.
        $this->mailer->to($address)
            ->sendNow(new Test());
    }
}
