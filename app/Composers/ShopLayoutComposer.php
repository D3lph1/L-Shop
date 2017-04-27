<?php

namespace App\Composers;

use App\Models\Server;
use App\Repositories\NewsRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\QueryManager;
use App\Contracts\ComposerContract;

/**
 * Class ShopLayoutComposer
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Composers
 */
class ShopLayoutComposer implements ComposerContract
{
    /**
     * Data about current server
     *
     * @var Server
     */
    private $currentServer;

    /**
     * Data about all enabled servers
     *
     * @var Server
     */
    private $servers;

    /**
     * @var QueryManager
     */
    private $qm;

    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @param Request        $request
     * @param QueryManager   $qm
     * @param NewsRepository $newsRepository
     */
    public function __construct(Request $request, QueryManager $qm, NewsRepository $newsRepository)
    {
        $this->currentServer = $request->get('currentServer');
        $this->servers = $request->get('servers');
        $this->qm = $qm;
        $this->newsRepository = $newsRepository;
    }

    /**
     * Compose the view
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->with($this->getData());
    }

    /**
     * @return array
     */
    private function getData()
    {
        if (s_get('news.enabled')) {
            $news = $this->news();
            $newsCount = $this->newsCount();
        } else {
            $news = false;
            $newsCount = 0;
        }

        return [
            'isAuth' => is_auth(),
            'isAdmin' => is_admin(),
            'username' => is_auth() ? \Sentinel::getUser()->getUserLogin() : null,
            'balance' => is_auth() ? \Sentinel::getUser()->getBalance() : null,
            'currency' => s_get('shop.currency_html', 'руб.'),
            'currentServer' => $this->currentServer,
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
            'newsCount' => $newsCount
        ];
    }

    /**
     * Get first portion of news list
     *
     * @return mixed
     */
    private function news()
    {
        return $this->newsRepository->getFirstPortion();
    }

    private function newsCount()
    {
        return $this->newsRepository->count();
    }
}
