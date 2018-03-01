<?php
declare(strict_types = 1);

namespace App\Composers;

use App\Composers\Constructors\AdminBlockConstructor;
use App\Composers\Constructors\ProfileBlockConstructor;
use App\Composers\Constructors\ServersBlockConstructor;
use App\DataTransferObjects\Frontend\Shop\News\Container;
use App\Handlers\Frontend\Shop\News\LoadHandler;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Auth;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use App\Services\Settings\Settings;
use Illuminate\Contracts\View\View;

class ShopLayoutComposer
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Auth $auth, Settings $settings)
    {
        $this->auth = $auth;
        $this->settings = $settings;
    }

    public function compose(View $view): void
    {
        $view->with($this->getData());
    }

    private function getData(): array
    {
        $server = app(Persistence::class)->retrieve();

        return [
            'isAuth' => $this->auth->check(),
            'isAdmin' => true,
            'username' => $this->auth->check() ? $this->auth->getUser()->getUsername() : null,
            'balance' => $this->auth->check() ? $this->auth->getUser()->getBalance() : null,
            'currency' => $this->settings->get('shop.currency.html')->getValue(),
            'cartCount' => $server !== null ? app(Cart::class)->countServer($server) : 0,
            'canLogin' => !$this->auth->check() && $this->settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
            'adminBlock' => app(AdminBlockConstructor::class)->construct(),
            'serversBlock' => app(ServersBlockConstructor::class)->construct(),
            'currentServerName' => $server !== null ? $server->getName() : __('content.layout.shop.server_not_selected'),
            'news' => $this->news(),
            'monitoringEnabled' => $this->settings->get('system.monitoring.enabled'),
            'monitoredServers' => $this->monitoredServers(),
            'server' => $server !== null ? $server : null,
            'shopName' => $this->settings->get('shop.name')->getValue(),
            'routeCatalog' => $server !== null ? route('frontend.catalog.render', ['server' => $server->getId()]) : route('frontend.servers'),
            'routeCart' => $server !== null ? route('frontend.cart.render', ['server' => $server->getId()]) : route('frontend.servers')
        ];
    }

    private function news(): Container
    {
        return app(LoadHandler::class)->load(1);
    }

    private function monitoredServers(): array
    {
        return [];
    }
}
