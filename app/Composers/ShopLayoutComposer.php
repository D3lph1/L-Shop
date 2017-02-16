<?php

namespace App\Composers;

use App\Models\Server;
use App\Services\QueryManager;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class ShopLayoutComposer
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Composers
 */
class ShopLayoutComposer
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
     * @param Request $request
     * @param QueryManager $qm
     */
    public function __construct(Request $request, QueryManager $qm)
    {
        $this->currentServer = $request->get('currentServer');
        $this->servers = $request->get('servers');
        $this->qm = $qm;
    }

    /**
     * Compose view
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
        return [
            'isAuth' => is_auth(),
            'username' => is_auth() ? \Sentinel::getUser()->getUserLogin() : null,
            'balance' => is_auth() ? \Sentinel::getUser()->getBalance() : null,
            'currency' => s_get('shop.currency_html', 'руб.'),
            'currentServer' => $this->currentServer,
            'servers' => $this->servers,
            'catalogUrl' => route('catalog', [
                'currentServer' => $this->currentServer
            ]),
            'cartUrl' => route('cart', [
                'server' => $this->currentServer->id
            ]),
            'signinUrl' => route('signin'),
            'logoutUrl' => route('logout'),
            'shopName' => s_get('shop.name', 'L - Shop')
        ];
    }
}
