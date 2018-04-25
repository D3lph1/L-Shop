<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Events\Auth\PasswordReminderCreated;
use App\Events\Auth\RegistrationSuccessEvent;
use App\Listeners\Auth\CreateLuckPermPlayer;
use App\Listeners\Auth\SendEmailConfirmation;
use App\Listeners\Auth\SendPasswordReminder;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RegistrationSuccessEvent::class => [
            SendEmailConfirmation::class
        ],
        PasswordReminderCreated::class => [
            SendPasswordReminder::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
