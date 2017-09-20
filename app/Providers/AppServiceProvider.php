<?php

namespace App\Providers;

use App\Models\Server;
use App\Repositories\Activation\ActivationRepositoryInterface;
use App\Repositories\Activation\EloquentActivationRepository;
use App\Repositories\Ban\BanRepositoryInterface;
use App\Repositories\Ban\EloquentBanRepository;
use App\Repositories\Cart\CartRepositoryInterface;
use App\Repositories\Cart\EloquentCartRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\EloquentCategoryRepository;
use App\Repositories\Item\EloquentItemRepository;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\News\EloquentNewsRepository;
use App\Repositories\News\NewsRepositoryInterface;
use App\Repositories\Page\EloquentPageRepository;
use App\Repositories\Page\PageRepositoryInterface;
use App\Repositories\Payment\EloquentPaymentRepository;
use App\Repositories\Payment\PaymentRepositoryInterface;
use App\Repositories\Product\EloquentProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Role\EloquentRoleRepository;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Server\EloquentServerRepository;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Repositories\User\EloquentUserRepository;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\Activator;
use App\Services\Cart;
use App\Services\CartBuy;
use App\Services\CatalogBuy;
use App\Services\Message;
use App\Services\Monitoring\MonitoringInterface;
use App\Services\Monitoring\RconMonitoring;
use App\Services\ReCaptcha;
use App\Services\Registrar;
use App\Services\SashokLauncher;
use D3lph1\MinecraftRconManager\Connector;
use D3lph1\MinecraftRconManager\Rcon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        \Validator::extend('alpha_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z]+$/', $value);
        });

        \Validator::extend('alpha_dash_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9_-]+$/', $value);
        });

        \Validator::extend('alpha_num_strict', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-zA-Z0-9]+$/', $value);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if (!Schema::hasTable('servers')) {
            return;
        }

        $this->app->alias(Message::class, 'message');

        $this->app->alias(Cart::class, 'cart');

        $this->app->bind('recaptcha', function () {
            return new ReCaptcha(
                s_get('recaptcha.public_key'),
                s_get('recaptcha.secret_key')
            );
        });

        $this->app->alias(Activator::class, 'activator');

        $this->app->alias(Activator::class, 'reminder');

        $this->app->alias(Registrar::class, 'registrar');

        $this->app->alias(CatalogBuy::class,'catalog.buy');

        $this->app->alias(CartBuy::class, 'cart.buy');

        $this->app->alias(SashokLauncher::class, 'launcher.sashok');

        $this->app->singleton(Rcon::class, function (Application $app) {
            $request = $app->make('request');
            $servers = $request->get('servers');

            if (!$servers) {
                // TODO: fix it
                $servers = $app->make(ServerRepositoryInterface::class)->all(['*']);
            }

            $rcon = new Connector();

            /** @var Server $server */
            foreach ($servers as $server) {
                $rcon->add($server->id, $server->ip, $server->port, $server->password, s_get('monitoring.rcon.timeout', 1));
            }

            return $rcon;
        });
        $this->app->alias(Rcon::class, Connector::class);
        $this->app->alias(Rcon::class, 'rcon');

        $this->app->singleton(MonitoringInterface::class, function (Application $app) {
            return new RconMonitoring($app->make(Rcon::class));
        });
        $this->app->alias(MonitoringInterface::class, 'monitoring');

        $this->app->singleton(BanRepositoryInterface::class, EloquentBanRepository::class);
        $this->app->singleton(PageRepositoryInterface::class, EloquentPageRepository::class);
        $this->app->singleton(NewsRepositoryInterface::class, EloquentNewsRepository::class);
        $this->app->singleton(ServerRepositoryInterface::class, EloquentServerRepository::class);
        $this->app->singleton(CategoryRepositoryInterface::class, EloquentCategoryRepository::class);
        $this->app->singleton(CartRepositoryInterface::class, EloquentCartRepository::class);
        $this->app->singleton(ItemRepositoryInterface::class, EloquentItemRepository::class);
        $this->app->singleton(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->singleton(PaymentRepositoryInterface::class, EloquentPaymentRepository::class);
        $this->app->singleton(ProductRepositoryInterface::class, EloquentProductRepository::class);
        $this->app->singleton(RoleRepositoryInterface::class, EloquentRoleRepository::class);
        $this->app->singleton(ActivationRepositoryInterface::class, EloquentActivationRepository::class);
    }
}
