<?php
declare(strict_types = 1);

namespace App\Listeners\Auth;

use App\Events\Auth\RegistrationSuccessEvent;
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
     * @param  RegistrationSuccessEvent  $event
     */
    public function handle(RegistrationSuccessEvent $event): void
    {
        $this->rolesInitializer->attachDefaultRoles($event->getUser());
    }
}
