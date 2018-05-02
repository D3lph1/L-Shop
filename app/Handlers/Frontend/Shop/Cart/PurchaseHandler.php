<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\DataTransferObjects\Frontend\Shop\Catalog\Purchase as ResultDTO;
use App\DataTransferObjects\Frontend\Shop\Purchase;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Server\ServerRepository;
use App\Services\Cart\Cart;
use App\Services\Purchasing\PurchaseProcessor;

class PurchaseHandler
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
     * @var PurchaseProcessor
     */
    private $processor;

    public function __construct(Cart $cart, ServerRepository $serverRepository, PurchaseProcessor $processor)
    {
        $this->cart = $cart;
        $this->serverRepository = $serverRepository;
        $this->processor = $processor;
    }

    /**
     * @param int         $serverId
     * @param null|string $username
     * @param string      $ip
     *
     * @return ResultDTO
     *
     * @throws ServerNotFoundException
     */
    public function handle(int $serverId, ?string $username, string $ip): ResultDTO
    {
        $server = $this->serverRepository->find($serverId);
        if ($server === null) {
            throw ServerNotFoundException::byId($serverId);
        }

        $items = $this->cart->retrieveServer($server);

        $DTOs = [];
        foreach ($items as $item) {
            $DTOs[] = new Purchase($item->getProduct(), $item->getAmount());
        }

        return $this->processor->process($DTOs, $username, $ip);
    }
}
