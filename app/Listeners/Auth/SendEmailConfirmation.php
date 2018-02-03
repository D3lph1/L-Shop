<?php
declare(strict_types = 1);

namespace App\Listeners\Auth;

use App\Services\Auth\Activator;
use App\Events\Auth\RegistrationSuccessEvent;
use App\Mail\Auth\Confirmation;
use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use Illuminate\Contracts\Mail\Mailer;

class SendEmailConfirmation
{
    /**
     * @var Activator
     */
    private $activator;

    /**
     * @var Pool
     */
    private $pool;

    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Activator $activator, Pool $pool, Mailer $mailer)
    {
        $this->activator = $activator;
        $this->pool = $pool;
        $this->mailer = $mailer;
    }

    public function handle(RegistrationSuccessEvent $event): void
    {
        if ($this->pool->has(ActivationCheckpoint::NAME)) {
            $activation = $this->activator->makeActivation($event->getUser());
            $this->mailer
                ->to($event->getUser()->getEmail())
                ->queue(new Confirmation($activation));
        } else {
            $this->activator->activate($event->getUser());
        }
    }
}
