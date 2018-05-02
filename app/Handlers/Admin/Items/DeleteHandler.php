<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items;

use App\Exceptions\Item\ItemNotFoundException;
use App\Repository\Item\ItemRepository;

class DeleteHandler
{
    /**
     * @var ItemRepository
     */
    private $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $itemId
     *
     * @throws ItemNotFoundException
     */
    public function handle(int $itemId): void
    {
        $item = $this->repository->find($itemId);
        if ($item === null) {
            throw ItemNotFoundException::byId($itemId);
        }

        $this->repository->remove($item);
    }
}
