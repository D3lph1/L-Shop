<?php
declare(strict_types = 1);

namespace App\Listeners\Auth;

use App\Events\Auth\RegistrationSuccessfulEvent;
use App\Services\User\RolesInitializer;

class AttachDefaultRoles
{
    /**
     * @var RolesInitializer
     */
    private $rolesInitializer;

    /**
     * Create the event listener.
     *
     * @param RolesInitializer $rolesInitializer
     */
    public function __construct(RolesInitializer $rolesInitializer)
    {
        $this->rolesInitializer = $rolesInitializer;
    }

    /**
     * Handle the event.
     *
     * @param  RegistrationSuccessfulEvent $event
     */
    public function handle(RegistrationSuccessfulEvent $event): void
    {
        $this->rolesInitializer->attachDefaultRoles($event->getUser());
    }
}
