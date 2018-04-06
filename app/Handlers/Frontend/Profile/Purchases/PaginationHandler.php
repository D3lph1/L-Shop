<?php
declare(strict_types=1);

namespace App\Handlers\Frontend\Profile\Purchases;

use App\DataTransferObjects\Frontend\Profile\Purchases\ListResult;
use App\Exceptions\InvalidArgumentException;
use App\Repository\Purchase\PurchaseRepository;

class PaginationHandler
{
    private const PER_PAGE = 25;

    /**
     * @var array
     */
    private $availableOrders = ['id', 'cost', 'createdAt', 'completedAt'];

    /**
     * @var PurchaseRepository
     */
    private $repository;

    public function __construct(PurchaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $page, ?string $orderBy, bool $descending): ListResult
    {
        if (!empty($orderBy) && !in_array($orderBy, $this->availableOrders)) {
            throw new InvalidArgumentException('Argument $orderBy has illegal value');
        }

        if ($orderBy !== null) {
            $paginator = $this->repository->findPaginatedWithOrder(
                $page,
                $orderBy,
                $descending,
                self::PER_PAGE
            );
        } else {
            $paginator = $this->repository->findPaginated($page, $perPage);
        }

        return new ListResult($paginator);
    }
}
