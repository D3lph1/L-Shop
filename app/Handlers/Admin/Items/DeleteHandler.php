<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items;

use App\Exceptions\Item\DoesNotExistException;
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
     * @throws DoesNotExistException
     */
    public function handle(int $itemId): void
    {
        $item = $this->repository->find($itemId);
        if ($item) {
            $this->repository->remove($item);

            return;
        }

        throw new DoesNotExistException($itemId);
    }
}
