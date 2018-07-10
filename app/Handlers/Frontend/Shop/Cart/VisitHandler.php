<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\DataTransferObjects\Frontend\Shop\CartResult;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use App\Services\Cart\Cart;
use App\Services\Server\Persistence\Persistence;
use App\Services\Server\ServerAccess;

class VisitHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Cart
     */
    private $cart;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Persistence
     */
    private $persistence;

    public function __construct(Auth $auth, Cart $cart, ServerRepository $serverRepository, Persistence $persistence)
    {
        $this->auth = $auth;
        $this->cart = $cart;
        $this->serverRepository = $serverRepository;
        $this->persistence = $persistence;
    }

    /**
     * @param int $serverId
     *
     * @return CartResult[]
     * @throws ServerNotFoundException
     * @throws ForbiddenException
     */
    public function handle(int $serverId): array
    {
        $server = $this->serverRepository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }

        if (!ServerAccess::isUserHasAccessTo($this->auth->getUser(), $server)) {
            throw new ForbiddenException("Server {$server} is disabled and the user does not have permissions to make a purchase");
        }

        $this->persistence->persist($server);

        $result = [];
        foreach ($this->cart->retrieveServer($server) as $item) {
            $result[] = new CartResult($item);
        }

        return $result;
    }
}
