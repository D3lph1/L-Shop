<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products\Edit;

use App\DataTransferObjects\Admin\Products\Add\Item;
use App\DataTransferObjects\Admin\Products\Add\Server;
use App\DataTransferObjects\Admin\Products\Edit\Product;
use App\DataTransferObjects\Admin\Products\Edit\Result;
use App\Exceptions\Product\DoesNotExistException;
use App\Repository\Item\ItemRepository;
use App\Repository\Product\ProductRepository;
use App\Repository\Server\ServerRepository;

class RenderHandler
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ItemRepository
     */
    private $itemRepository;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    public function __construct(
        ProductRepository $productRepository,
        ItemRepository $itemRepository,
        ServerRepository $serverRepository)
    {
        $this->productRepository = $productRepository;
        $this->itemRepository = $itemRepository;
        $this->serverRepository = $serverRepository;
    }

    public function handle(int $productId): Result
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw new DoesNotExistException($productId);
        }

        $items = [];
        foreach ($this->itemRepository->findAll() as $item) {
            $items[] = new Item($item);
        }

        $servers = [];
        foreach ($this->serverRepository->findAll() as $server) {
            $servers[] = new Server($server);
        }

        return new Result(new Product($product), $items, $servers);
    }
}
