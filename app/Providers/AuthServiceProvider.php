<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Generators\DefaultCodeGenerator;
use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Hashing\BcryptHasher;
use App\Services\Auth\Hashing\Hasher;
use App\Services\Auth\Session\Driver\Cookie;
use App\Services\Auth\Session\Driver\Driver;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->app->singleton(Driver::class, Cookie::class);
        $this->app->bind(Hasher::class, BcryptHasher::class);
        $this->app->bind(CodeGenerator::class, DefaultCodeGenerator::class);
        $this->app->singleton(Pool::class, function () {
            return new Pool([
                $this->app->make(ActivationCheckpoint::class)
            ]);
        });
    }
}
