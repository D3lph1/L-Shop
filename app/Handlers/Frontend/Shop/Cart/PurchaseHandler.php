<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Cart;

use App\DataTransferObjects\Frontend\Shop\Cart\Purchase as PurchaseDTO;
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
     * @param PurchaseDTO $dto
     *
     * @return ResultDTO
     */
    public function handle(PurchaseDTO $dto): ResultDTO
    {
        $server = $this->serverRepository->find($dto->getServerId());
        if ($server === null) {
            throw ServerNotFoundException::byId($dto->getServerId());
        }

        $items = $this->cart->retrieveServer($server);
        // If cart is empty for this server.
        if (count($items) === 0) {
            throw new \LogicException("Cart can not been empty");
        }

        $DTOs = [];
        foreach ($items as $fromServerCart) {
            foreach ($dto->getItems() as $fromClientCartProduct => $fromClientCartAmount) {
                if ($fromServerCart->getProduct()->getId() === $fromClientCartProduct) {
                    $DTOs[] = new Purchase($fromServerCart->getProduct(), $fromClientCartAmount);
                }
            }
        }

        $result = $this->processor->process($DTOs, $dto->getUsername(), $dto->getIp());

        // Remove all data in cart for this server.
        $this->cart->removeServer($server);

        return $result;
    }
}
