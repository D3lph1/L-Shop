<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Entity\User;
use App\Exceptions\UnexpectedValueException;
use App\Repository\Throttle\ThrottleRepository;
use App\Services\Auth\Activator;
use App\Services\Auth\Auth;
use App\Services\Auth\Authenticator;
use App\Services\Auth\BanManager;
use App\Services\Auth\Checkpoint\Checkpoint;
use App\Services\Auth\Checkpoint\Pool;
use App\Services\Auth\Checkpoint\ThrottleCheckpoint;
use App\Services\Auth\DefaultActivator;
use App\Services\Auth\DefaultAuth;
use App\Services\Auth\DefaultAuthenticator;
use App\Services\Auth\DefaultBanManager;
use App\Services\Auth\DefaultRegistrar;
use App\Services\Auth\DefaultReminder;
use App\Services\Auth\DefaultThrottlingManager;
use App\Services\Auth\Generators\CodeGenerator;
use App\Services\Auth\Generators\DefaultCodeGenerator;
use App\Services\Auth\Hashing\Hasher;
use App\Services\Auth\Registrar;
use App\Services\Auth\Reminder;
use App\Services\Auth\Session\Driver\Cookie;
use App\Services\Auth\Session\Driver\Driver;
use App\Services\Auth\ThrottlingManager;
use App\Services\Auth\ThrottlingOptions;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->app->singleton(Driver::class, Cookie::class);
        $this->app->bind(Hasher::class, function (Application $app) {
            $hasher = $app->make($app->make(Repository::class)->get('auth.hasher'));
            if (!($hasher instanceof Hasher)) {
                throw new UnexpectedValueException(
                    'Auth hasher must be implements ' . Hasher::class . ' interface'
                );
            }

            return $hasher;
        });
        $this->app->bind(CodeGenerator::class, DefaultCodeGenerator::class);
        $this->app->singleton(Pool::class, function (Application $app) {
            $checkpointClasses = $app->make(Repository::class)->get('auth.checkpoints');
            $checkpoints = [];
            foreach ($checkpointClasses as $checkpointClass) {
                $checkpoint = $app->make($checkpointClass);
                if (!($checkpoint instanceof Checkpoint)) {
                    throw new UnexpectedValueException(
                        'Checkpoint must be implements ' . Checkpoint::class . ' interface'
                    );
                }
                $checkpoints[] = $checkpoint;
            }

            return new Pool($checkpoints);
        });
        $this->app->singleton(Auth::class, DefaultAuth::class);
        $this->app->singleton(Authenticator::class, DefaultAuthenticator::class);
        $this->app->singleton(Registrar::class, DefaultRegistrar::class);
        $this->app->singleton(Activator::class, DefaultActivator::class);
        $this->app->singleton(Reminder::class, DefaultReminder::class);
        $this->app->singleton(BanManager::class, DefaultBanManager::class);

        $this->app->singleton(User::class, function (Application $app) {
            return $app->make(Auth::class)->getUser();
        });

        $this->app->singleton(ThrottlingOptions::class, function (Application $app) {
            $config = $app->make(Repository::class);
            $cfgPrefix = 'auth.throttling';

            return (new ThrottlingOptions())
                ->setGlobalAttempts($config->get("{$cfgPrefix}.global.attempts"))
                ->setGlobalCooldown($config->get("{$cfgPrefix}.global.cooldown"))
                ->setIpAttempts($config->get("{$cfgPrefix}.ip.attempts"))
                ->setIpCooldown($config->get("{$cfgPrefix}.ip.cooldown"))
                ->setUserAttempts($config->get("{$cfgPrefix}.user.attempts"))
                ->setUserCooldown($config->get("{$cfgPrefix}.user.cooldown"));
        });
        $this->app->singleton(ThrottlingManager::class, DefaultThrottlingManager::class);
        $this->app->singleton(ThrottleCheckpoint::class, function (Application $app) {
            return new ThrottleCheckpoint(
                $app->make(ThrottleRepository::class),
                $app->make(ThrottlingManager::class),
                $app->make(Request::class)->ip()
            );
        });
    }
}
