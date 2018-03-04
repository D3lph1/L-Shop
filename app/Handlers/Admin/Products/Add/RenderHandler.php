<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products\Add;

use App\DataTransferObjects\Admin\Products\Add\Item;
use App\DataTransferObjects\Admin\Products\Add\Result;
use App\DataTransferObjects\Admin\Products\Add\Server;
use App\Repository\Item\ItemRepository;
use App\Repository\Server\ServerRepository;

class RenderHandler
{
    /**
     * @var ItemRepository
     */
    private $itemRepository;
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    public function __construct(ItemRepository $itemRepository, ServerRepository $serverRepository)
    {
        $this->itemRepository = $itemRepository;
        $this->serverRepository = $serverRepository;
    }

    public function handle(): Result
    {
        $items = [];
        foreach ($this->itemRepository->findAll() as $item) {
            $items[] = new Item($item);
        }

        $servers = [];
        foreach ($this->serverRepository->findAll() as $server) {
            $servers[] = new Server($server);
        }

        return new Result($items, $servers);
    }
}
