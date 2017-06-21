<?php

namespace App\Providers;

use App\Repositories\BanRepository;
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
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerPolicies();

        $banCheckpoint = new BanCheckpoint($this->app->make(BanRepository::class));
        \Sentinel::addCheckpoint('ban', $banCheckpoint);
    }
}
