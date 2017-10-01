<?php
declare(strict_types = 1);

namespace App\Listeners;

use App\Events\UserWasRegistered;
use Cartalyst\Sentinel\Users\UserInterface;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SendUserActivationMail
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Listeners
 */
class SendUserActivationMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserWasRegistered  $event
     * @return void
     */
    public function handle(UserWasRegistered $event)
    {
        if ($event->isNeedSendActivationMail()) {
            $this->activate($event->getUser());
        }
    }

    /**
     * Create new activation and send email
     *
     * @param UserInterface $user
     */
    private function activate(UserInterface $user)
    {
        \App::make('activator')->createAndSend($user);
    }
}
