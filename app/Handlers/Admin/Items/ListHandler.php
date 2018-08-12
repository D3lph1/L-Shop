<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Items;

use App\DataTransferObjects\Admin\Items\EditList\Result;
use App\DataTransferObjects\PaginationList;
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

    public function handle(PaginationList $dto): Result
    {
        if (!empty($dto->getOrderBy()) && !in_array($dto->getOrderBy(), $this->availableOrders)) {
            throw new InvalidArgumentException('Argument $orderBy has illegal value');
        }

        if ($dto->getOrderBy() !== null) {
            if (!empty($dto->getSearch())) {
                $paginator = $this->repository->findPaginatedWithOrderAndSearch(
                    $dto->getOrderBy(),
                    $dto->isDescending(),
                    $dto->getSearch(),
                    $dto->getPage(),
                    $dto->getPerPage()
                );
            } else {
                $paginator = $this->repository->findPaginatedWithOrder(
                    $dto->getOrderBy(),
                    $dto->isDescending(),
                    $dto->getPage(),
                    $dto->getPerPage()
                );
            }
        } else {
            if (!empty($dto->getSearch())) {
                $paginator = $this->repository->findPaginateWithSearch(
                    $dto->getSearch(),
                    $dto->getPage(),
                    $dto->getPerPage()
                );
            } else {
                $paginator = $this->repository->findPaginated($dto->getPage(), $dto->getPerPage());
            }
        }

        return new Result($paginator);
    }
}
