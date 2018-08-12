<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Frontend\Shop;

use App\Composers\Constructors\AdminBlockConstructor;
use App\DataTransferObjects\Frontend\Shop\Server;
use App\Handlers\Frontend\News\LoadHandler;
use App\Http\Controllers\Controller;
use App\Services\Auth\AccessMode;
use App\Services\Auth\Auth;
use App\Services\Cart\Cart;
use App\Services\Media\Character\Cloak\Accessor as CloakAccessor;
use App\Services\Media\Character\Skin\Accessor as SkinAccessor;
use App\Services\Meta\System;
use App\Services\Response\JsonResponse;
use App\Services\Response\Status;
use App\Services\Server\Persistence\Persistence;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

/**
 * Class ShopController
 * Handles requests that come from the shop layer.
 */
class ShopController extends Controller
{
    /**
     * Returns the data to render the store layer.
     *
     * @param AdminBlockConstructor $adminBlockConstructor
     * @param Settings              $settings
     * @param LoadHandler           $loadHandler
     * @param Persistence           $persistence
     * @param Auth                  $auth
     * @param Cart                  $cart
     * @param SkinAccessor          $skinAccessor
     * @param CloakAccessor         $cloakAccessor
     *
     * @return JsonResponse
     */
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
            'accessModeAny' => $settings->get('auth.access_mode')->getValue() === AccessMode::ANY,
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
