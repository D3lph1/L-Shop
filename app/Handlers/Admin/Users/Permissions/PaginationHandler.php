<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users\Permissions;

use App\DataTransferObjects\Admin\Users\Permissions\ListResult;
use App\DataTransferObjects\PaginationList;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Permission\PermissionRepository;

class PaginationHandler
{
    private $availableOrders = ['permission.id', 'permission.name'];

    /**
     * @var PermissionRepository
     */
    private $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PaginationList $dto)
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
            if (!empty($search)) {
                $paginator = $this->repository->findPaginateWithSearch(
                    $dto->getSearch(),
                    $dto->getPage(),
                    $dto->getPerPage()
                );
            } else {
                $paginator = $this->repository->findPaginated($dto->getPage(), $dto->getPerPage());
            }
        }

        return new ListResult($paginator);
    }
}
