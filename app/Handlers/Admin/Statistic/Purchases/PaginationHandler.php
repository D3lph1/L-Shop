<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic\Purchases;

use App\DataTransferObjects\Admin\Statistic\Purchases\PaginationResult;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Purchase\PurchaseRepository;

class PaginationHandler
{
    /**
     * @var array
     */
    private $availableOrders = [
        'purchase.id',
        'purchase.cost',
        'purchase.player',
        'purchase.createdAt',
        'purchase.completedAt',
        'purchase.via'
    ];

    /**
     * @var PurchaseRepository
     */
    private $repository;

    public function __construct(PurchaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $page, int $perPage, ?string $orderBy, bool $descending): PaginationResult
    {
        if (!empty($orderBy) && !in_array($orderBy, $this->availableOrders)) {
            throw new InvalidArgumentException('Argument $orderBy has illegal value');
        }

        if ($orderBy !== null) {
            $paginator = $this->repository->findPaginatedWithOrder(
                $page,
                $orderBy,
                $descending,
                $perPage
            );
        } else {
            $paginator = $this->repository->findPaginated($page, $perPage);
        }

        return new PaginationResult($paginator);
    }
}
