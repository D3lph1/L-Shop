<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items;

use App\DataTransferObjects\Admin\Items\EditList\Result;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Item\ItemRepository;

class ListHandler
{
    private $availableOrders = ['id', 'name', 'type'];

    /**
     * @var ItemRepository
     */
    private $repository;

    public function __construct(ItemRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(?string $orderBy, bool $descending, ?string $search, int $perPage): Result
    {
        if (!empty($orderBy) && !in_array($orderBy, $this->availableOrders)) {
            throw new InvalidArgumentException('Argument $orderBy has illegal value');
        }

        if ($orderBy !== null) {
            if (!empty($search)) {
                $paginator = $this->repository->findPaginatedWithOrderAndSearch(
                    $orderBy,
                    $descending,
                    $search,
                    $perPage
                );
            } else {
                $paginator = $this->repository->findPaginatedWithOrder(
                    $orderBy,
                    $descending,
                    $perPage
                );
            }
        } else {
            if (!empty($search)) {
                $paginator = $this->repository->findPaginateWithSearch($search, $perPage);
            } else {
                $paginator = $this->repository->findPaginated($perPage);
            }
        }

        return new Result($paginator);
    }
}
