<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\DataTransferObjects\Frontend\Shop\CartResult;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Services\Cart\Cart;
use App\Services\Infrastructure\Server\Persistence\Persistence;

class VisitHandler
{
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

    public function __construct(Cart $cart, ServerRepository $serverRepository, Persistence $persistence)
    {
        $this->cart = $cart;
        $this->serverRepository = $serverRepository;
        $this->persistence = $persistence;
    }

    /**
     * @param int $serverId
     *
     * @return CartResult[]
     * @throws ServerNotFoundException
     */
    public function handle(int $serverId): array
    {
        $server = $this->serverRepository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }
        $this->persistence->persist($server);

        $result = [];
        foreach ($this->cart->retrieveServer($server) as $item) {
            $result[] = new CartResult($item);
        }
        return $result;
    }
}
