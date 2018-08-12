<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic\Show;

use App\Repository\Purchase\PurchaseRepository;
use App\Services\Purchasing\ViaContext;

class ProfitForMonthHandler
{
    /**
     * @var PurchaseRepository
     */
    private $repository;

    public function __construct(PurchaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $year, int $month): array
    {
        $items = $this->repository->retrieveTotalProfitForMonthCompleted($year, $month, [ViaContext::BY_ADMIN]);
        foreach ($items as $key => &$item) {
            $items[$key]['day'] = (int)$item['day'];
            $items[$key]['total'] = (int)$item['total'];
        }

        return $items;
    }
}
