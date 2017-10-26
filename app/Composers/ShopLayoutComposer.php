<?php
declare(strict_types = 1);

namespace App\Composers;

use App\Contracts\ComposerContract;
use App\DataTransferObjects\MonitoringPlayers;
use App\Models\Server\ServerInterface;
use App\Repositories\News\NewsRepositoryInterface;
use App\Services\Monitoring\MonitoringInterface;
use App\Traits\ContainerTrait;
use App\TransactionScripts\Monitoring;
use App\TransactionScripts\Shop\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ShopLayoutComposer
 * Serves to transfer shared data to a layout.shop template that will be available
 * on each child page of this template.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Composers
 */
class ShopLayoutComposer implements ComposerContract
{
    use ContainerTrait;

    /**
     * @var Request
     */
    private $request;

    /**
     * Data about current server
     *
     * @var ServerInterface
     */
    private $currentServer;

    /**
     * Data about all enabled servers.
     *
     * @var ServerInterface[]
     */
    private $servers;

    /**
     * @var MonitoringInterface
     */
    private $monitoring;

    public function __construct(Request $request, MonitoringInterface $monitoring)
    {
        $this->request = $request;
        $this->currentServer = $request->get('currentServer');
        $this->servers = $request->get('servers');
        $this->monitoring = $monitoring;
    }

    /**
     * {@inheritdoc}
     */
    public function compose(View $view): void
    {
        $view->with($this->getData());
    }

    /**
     * Obtain information for subsequent composing.
     */
    private function getData(): array
    {
        if (s_get('news.enabled')) {
            $news = $this->news();
            $newsCount = $this->newsCount();
        } else {
            $news = false;
            $newsCount = 0;
        }

        \Debugbar::info(\App::make('rcon'));
        return [
            'isAuth' => is_auth(),
            'isAdmin' => is_admin(),
            'username' => is_auth() ? \Sentinel::getUser()->getUsername() : null,
            'balance' => is_auth() ? \Sentinel::getUser()->getBalance() : null,
            'currency' => s_get('shop.currency_html', 'руб.'),
            'currentServer' => $this->currentServer,
            'character' =>
                s_get('profile.character.skin.enabled', 0) or s_get('profile.character.cloak.enabled', 0),

            'canEnter' => access_mode_any() and !is_auth(),
            'servers' => $this->servers,
            'catalogUrl' => route('catalog', [
                'currentServer' => $this->currentServer
            ]),
            'cartUrl' => route('cart', [
                'server' => $this->currentServer->id
            ]),
            'signinUrl' => route('signin'),
            'logoutUrl' => route('logout'),
            'shopName' => s_get('shop.name', 'L - Shop'),
            'news' => $news,
            'newsCount' => $newsCount,
            'monitoring' => $this->monitoring()
        ];
    }

    /**
     * Get first portion of news list.
     */
    private function news(): iterable
    {
        /** @var News $script */
        $script = $this->make(News::class);

        return $script->firstPortion();
    }

    /**
     * Get all news count.
     */
    private function newsCount(): int
    {
        /** @var NewsRepositoryInterface $repository */
        $repository = $this->make(NewsRepositoryInterface::class);

        return $repository->count();
    }

    /**
     * Obtain data for monitoring servers.
     *
     * @return MonitoringPlayers[]
     */
    private function monitoring(): array
    {
        /** @var Monitoring $monitoring */
        $monitoring = $this->make(Monitoring::class);

        return $monitoring->forServers($this->request->get('servers'));
    }
}
