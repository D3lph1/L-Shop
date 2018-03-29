<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Repository\BalanceTransaction\BalanceTransactionRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Checkpoint\ActivationCheckpoint;
use App\Services\Auth\Checkpoint\BanCheckpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Generators\DefaultCodeGenerator;
use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Hashing\BcryptHasher;
use App\Services\Auth\Hashing\Hasher;
use App\Services\Auth\Session\Driver\Cookie;
use App\Services\Auth\Session\Driver\Driver;
use App\Services\User\Balance\Transactor;
use Illuminate\Contracts\Container\BindingResolutionException;
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
                $this->app->make(ActivationCheckpoint::class),
                $this->app->make(BanCheckpoint::class)
            ]);
        });
        $this->app->singleton(Auth::class);

        $this->app->bind(Transactor::class, function () {
            $auth = $this->app->make(Auth::class);
            if (!$auth->check()) {
                throw new BindingResolutionException(
                    'Can not resolve parameter $user in App\Services\User\Balance\Transactor::_construct(). User must be authenticated.'
                );
            }

            return new Transactor(
                $this->app->make(BalanceTransactionRepository::class),
                $auth->getUser()
            );
        });
    }
}
