<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\News;

use App\DataTransferObjects\Admin\News\ListResult;
use App\Exceptions\InvalidArgumentException;
use App\Repository\News\NewsRepository;

class ListHandler
{
    private $availableOrders = ['news.id', 'news.title', 'news.createdAt', 'user.username'];

    /**
     * @var NewsRepository
     */
    private $repository;

    public function __construct(NewsRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(?string $orderBy, bool $descending, ?string $search, int $perPage): ListResult
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

        return new ListResult($paginator);
    }
}
