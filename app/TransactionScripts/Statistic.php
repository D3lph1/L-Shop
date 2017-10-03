<?php
declare(strict_types = 1);

namespace App\TransactionScripts;

use App\DataTransferObjects\Admin\Statistic as DTO;
use App\Repositories\Payment\PaymentRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Cache\Repository;

/**
 * Class Statistic
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\TransactionScripts
 */
class Statistic
{
    private $paymentRepository;

    private $cache;

    public function __construct(PaymentRepositoryInterface $paymentRepository, Repository $cache)
    {
        $this->paymentRepository = $paymentRepository;
        $this->cache = $cache;
    }

    public function statistic(?string $month): DTO
    {
        $currentMonth = (int)($month ?: Carbon::now()->format('n'));
        $currentMonthWord = new Carbon();
        $currentMonthWord->month = $currentMonth;
        $currentMonthWord = humanize_month($currentMonthWord->formatLocalized('%B'));

        return (new DTO())
            ->setCompletedForYear($this->paymentRepository->forTheLastYearCompleted(['products', 'cost', 'updated_at']))
            ->setProfit($this->paymentRepository->profit())
            ->setCurrentMonth($currentMonth)
            ->setCurrentMonthHumanized($currentMonthWord);
    }

    public function flushCache(): void
    {
        $this->cache->forget('admin.statistic.for_the_last_year_completed');
        $this->cache->forget('admin.statistic.profit');
    }
}
