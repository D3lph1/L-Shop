<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic\Show;

use App\Repository\User\UserRepository;

class RegisteredForMonthHandler
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(int $year, int $month): array
    {
        $items = $this->repository->retrieveCreatedForMonth($year, $month);
        foreach ($items as $key => &$item) {
            $items[$key]['day'] = (int)$item['day'];
            $items[$key]['amount'] = (int)$item['amount'];
        }

        return $items;
    }
}
