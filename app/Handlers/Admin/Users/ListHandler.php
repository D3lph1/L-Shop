<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Users;

use App\DataTransferObjects\Admin\Users\ListResult;
use App\Exceptions\InvalidArgumentException;
use App\Repository\User\UserRepository;

class ListHandler
{
    private $availableOrders = ['id', 'username', 'email'];

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
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
