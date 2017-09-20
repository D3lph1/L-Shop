<?php

namespace App\Providers;

use App\Models\Activation\EloquentActivation;
use App\Models\Role\EloquentRole;
use App\Models\User\EloquentUser;
use App\Repositories\Activation\ActivationRepositoryInterface;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\BanCheckpoint;
use Cartalyst\Sentinel\Checkpoints\CheckpointInterface;
use Cartalyst\Sentinel\Hashing\BcryptHasher;
use Cartalyst\Sentinel\Hashing\HasherInterface;
use Cartalyst\Sentinel\Sentinel;
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

        /** @var CheckpointInterface $banCheckpoint */
        $banCheckpoint = $this->app->make(BanCheckpoint::class);
        $sentinel = $this->app->make(Sentinel::class);
        $sentinel->addCheckpoint('ban', $banCheckpoint);
        $this->app->singleton(HasherInterface::class, BcryptHasher::class);
        $sentinel->setUserRepository($this->app->make(UserRepositoryInterface::class, ['model' => EloquentUser::class]));
        $sentinel->setRoleRepository($this->app->make(RoleRepositoryInterface::class, ['model' => EloquentRole::class]));
        $sentinel->setActivationRepository($this->app->make(ActivationRepositoryInterface::class, ['model' => EloquentActivation::class]));
    }
}
