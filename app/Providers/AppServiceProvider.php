<?php
declare(strict_types = 1);

namespace App\Providers;

use App\Repository\Server\ServerRepository;
use App\Services\Caching\CachingRepository;
use App\Services\Caching\IlluminateCachingRepository;
use App\Services\Cart\Storage\Session as SessionCartStorage;
use App\Services\Cart\Storage\Storage as ClassStorage;
use App\Services\Database\Truncater\MySQLTruncater;
use App\Services\Database\Truncater\PostgreSQLTruncater;
use App\Services\Database\Truncater\Truncater;
use App\Services\DateTime\Formatting\Formatter;
use App\Services\DateTime\Formatting\HumanizeFormatter;
use App\Services\Infrastructure\Notification\Drivers\Driver;
use App\Services\Infrastructure\Notification\Drivers\Session;
use App\Services\Infrastructure\Security\Captcha\Captcha;
use App\Services\Infrastructure\Security\Captcha\ReCaptcha;
use App\Services\Infrastructure\Server\Persistence\Storage\Session as SessionPersistenceStorage;
use App\Services\Infrastructure\Server\Persistence\Storage\Storage as PersistenceStorage;
use App\Services\Item\Image\Hashing\Hasher;
use App\Services\Item\Image\Hashing\MD5Hasher;
use App\Services\Media\Character\Cloak\Applicators\Applicator as CloakApplicator;
use App\Services\Media\Character\Cloak\Applicators\DefaultApplicator as DefaultCloakApplicator;
use App\Services\Media\Character\Skin\Applicators\Applicator as SkinApplicator;
use App\Services\Media\Character\Skin\Applicators\DefaultApplicator as DefaultSkinApplicator;
use App\Services\Monitoring\Drivers\Driver as MonitoringDriver;
use App\Services\Monitoring\Drivers\Rcon as RconMonitoring;
use App\Services\Monitoring\Drivers\RconResponseParser;
use App\Services\Monitoring\Monitoring;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use D3lph1\MinecraftRconManager\Connector;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

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
        $this->app->singleton(Formatter::class, HumanizeFormatter::class);
        $this->app->bind(SkinApplicator::class, DefaultSkinApplicator::class);
        $this->app->bind(CloakApplicator::class, DefaultCloakApplicator::class);
        $this->app->singleton(Captcha::class, function () {
            $settings = $this->app->make(Settings::class);
            return new ReCaptcha(
                $settings->get('system.security.captcha.recaptcha.public_key')->getValue(),
                $settings->get('system.security.captcha.recaptcha.secret_key')->getValue()
            );
        });
        $this->app->singleton(Hasher::class, MD5Hasher::class);

        $this->app->singleton(CachingRepository::class, IlluminateCachingRepository::class);

        $this->app->singleton(MonitoringDriver::class, function () {
            $settings = $this->app->make(Settings::class);

            return $this->app->make(RconMonitoring::class, [
                'connector' => new Connector(),
                'command' => $settings->get('system.monitoring.rcon.command')->getValue(),
                'timeout' => $settings->get('system.monitoring.rcon.timeout')->getValue(DataType::INT),
                'parser' => $this->app->make(RconResponseParser::class, [
                    'pattern' =>  $settings->get('system.monitoring.rcon.pattern')->getValue()
                ])
            ]);
        });

        $this->app->singleton(Monitoring::class, function () {
            $settings = $this->app->make(Settings::class);

            return new Monitoring(
                $this->app->make(ServerRepository::class),
                $this->app->make(MonitoringDriver::class),
                $this->app->make(CachingRepository::class),
                $this->app->make(LoggerInterface::class),
                $settings->get('system.monitoring.rcon.ttl')->getValue(DataType::FLOAT)
            );
        });
    }

    private function registerTruncater(): void
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
