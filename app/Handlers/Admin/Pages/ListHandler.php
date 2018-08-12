<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Pages;

use App\DataTransferObjects\Admin\Pages\ListResult;
use App\DataTransferObjects\PaginationList;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Page\PageRepository;

class ListHandler
{
    private $availableOrders = ['id', 'title', 'url'];

    /**
     * @var PageRepository
     */
    private $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(PaginationList $dto): ListResult
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

        return new ListResult($paginator);
    }
}
