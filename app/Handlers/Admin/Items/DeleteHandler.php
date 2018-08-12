<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items;

use App\Events\Item\ItemWillBeDeletedEvent;
use App\Exceptions\Item\ItemNotFoundException;
use App\Repository\Item\ItemRepository;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteHandler
{
    /**
     * @var ItemRepository
     */
    private $repository;

    /**
     * @var Dispatcher
     */
    private $eventDispatcher;

    public function __construct(ItemRepository $repository, Dispatcher $eventDispatcher)
    {
        $this->repository = $repository;
        $this->eventDispatcher = $eventDispatcher;
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

        $this->eventDispatcher->dispatch(new ItemWillBeDeletedEvent($item));
        $this->repository->remove($item);
    }
}
