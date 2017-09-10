<?php

namespace App\Providers;

use App\Services\BanCheckpoint;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        $banCheckpoint = $this->app->make(BanCheckpoint::class);
        \Sentinel::addCheckpoint('ban', $banCheckpoint);
    }
}
