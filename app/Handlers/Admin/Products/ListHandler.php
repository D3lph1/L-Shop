<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Products;

use App\DataTransferObjects\Admin\Products\EditList\Result;
use App\DataTransferObjects\PaginationList;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Product\ProductRepository;

class ListHandler
{
    private $availableOrders = [
        'product.id',
        'product.price',
        'product.stack',
        'item.name',
        'item.type',
        'server.name',
        'category.name'
    ];

    /**
     * @var ProductRepository
     */
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PaginationList $dto): Result
    {
        if (!empty($dto->getOrderBy()) && !in_array($dto->getOrderBy(), $this->availableOrders)) {
            throw new InvalidArgumentException('`OrderBy` has illegal value');
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
