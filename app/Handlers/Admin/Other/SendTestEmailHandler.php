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

    public function handle(string $address): void
    {
        $this->mailer->to($address)
            ->queue(new Test());
    }
}
