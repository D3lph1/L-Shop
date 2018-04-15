<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Composers\Constructors\AdminBlockConstructor;
use App\DataTransferObjects\Frontend\Shop\Server;
use App\Handlers\Frontend\News\LoadHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\Auth;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Meta\System;
use App\Services\Infrastructure\Response\JsonResponse;
use App\Services\Infrastructure\Response\Status;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use App\Services\Media\Character\Cloak\Accessor as CloakAccessor;
use App\Services\Media\Character\Skin\Accessor as SkinAccessor;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class ShopController extends Controller
{
    public function render(
        AdminBlockConstructor $adminBlockConstructor,
        Settings $settings,
        LoadHandler $loadHandler,
        Persistence $persistence,
        Auth $auth,
        Cart $cart,
        SkinAccessor $skinAccessor,
        CloakAccessor $cloakAccessor)
    {
        $server = $persistence->retrieve();
        if ($server !== null) {
            $server = new Server($server);
        }

        $character = false;
        $balance = null;
        if ($auth->check()) {
            $character = $skinAccessor->allowSet($auth->getUser()) || $cloakAccessor->allowSet($auth->getUser());
            $balance = $auth->getUser()->getBalance();
        }

        $newsEnabled = $settings->get('system.news.enabled')->getValue(DataType::BOOL);
        $news = null;
        if ($newsEnabled) {
            $news = $loadHandler->load(1);
        }

        return new JsonResponse(Status::SUCCESS, [
            'currency' => [
                'plain' => $settings->get('shop.currency.name')->getValue(),
                'html' => $settings->get('shop.currency.html')->getValue()
            ],
            'character' => $character,
            'sidebar' => [
                'admin' => $adminBlockConstructor->construct()
            ],
            'auth' => [
                'user' => [
                    'balance' => $balance
                ]
            ],
            'cart' => [
                'amount' => $persistence->retrieve() ? count($cart->retrieveServer($persistence->retrieve())) : null
            ],
            'news' => [
                'enabled' => $newsEnabled,
                'portion' => $news,
            ],
            'server' => $server,
            'github' => System::githubRepositoryUrl()
        ]);
    }
}
