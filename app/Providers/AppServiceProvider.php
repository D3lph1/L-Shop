<?php

namespace App\Providers;

use App\Services\Cart\Storage\Session as SessionCartStorage;
use App\Services\Cart\Storage\Storage as ClassStorage;
use App\Services\Database\Truncater\MySQLTruncater;
use App\Services\Database\Truncater\PostgreSQLTruncater;
use App\Services\Database\Truncater\Truncater;
use App\Services\DateTime\Formatting\DefaultFormatter;
use App\Services\DateTime\Formatting\Formatter;
use App\Services\Infrastructure\Notification\Drivers\Driver;
use App\Services\Infrastructure\Notification\Drivers\Session;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Infrastructure\Security\Captcha\ReCaptcha;
use App\Services\Infrastructure\Server\Persistence\Storage\Session as SessionPersistenceStorage;
use App\Services\Infrastructure\Server\Persistence\Storage\Storage as PersistenceStorage;
use App\Services\Media\Character\Cloak\Applicators\Applicator as CloakApplicator;
use App\Services\Media\Character\Cloak\Applicators\DefaultApplicator as DefaultCloakApplicator;
use App\Services\Media\Character\Skin\Applicators\Applicator as SkinApplicator;
use App\Services\Media\Character\Skin\Applicators\DefaultApplicator as DefaultSkinApplicator;
use App\Services\Settings\Settings;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerTruncater();

        $this->app->singleton(Driver::class, Session::class);
        $this->app->singleton(PersistenceStorage::class, SessionPersistenceStorage::class);
        $this->app->singleton(ClassStorage::class, SessionCartStorage::class);
        $this->app->singleton(Formatter::class, DefaultFormatter::class);
        $this->app->bind(SkinApplicator::class, DefaultSkinApplicator::class);
        $this->app->bind(CloakApplicator::class, DefaultCloakApplicator::class);
        $this->app->singleton(Captcha::class, function () {
            $settings = $this->app->make(Settings::class);
            return new ReCaptcha(
                $settings->get('system.security.captcha.recaptcha.public_key')->getValue(),
                $settings->get('system.security.captcha.recaptcha.secret_key')->getValue()
            );
        });
    }

    private function registerTruncater()
    {
        $defaultConnection = config('database.default');
        $driver = config("database.connections.{$defaultConnection}.driver");
        switch ($driver) {
            case 'mysql':
                $this->app->singleton(Truncater::class, MySQLTruncater::class);
                break;
            case 'pgsql':
                $this->app->singleton(Truncater::class, PostgreSQLTruncater::class);
                break;
        }
    }
}
