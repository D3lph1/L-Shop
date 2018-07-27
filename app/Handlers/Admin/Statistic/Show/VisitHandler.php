<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Statistic\Show;

use App\DataTransferObjects\Admin\Statistic\Show\VisitResult;
use App\Repository\Purchase\PurchaseRepository;
use App\Repository\PurchaseItem\PurchaseItemRepository;
use App\Repository\User\UserRepository;
use App\Services\Purchasing\ViaContext;

class VisitHandler
{
    public const TOP_PURCHASED_PRODUCTS_MAX_POSITIONS = 10;

    /**
     * @var PurchaseRepository
     */
    private $purchaseRepository;

    /**
     * @var PurchaseItemRepository
     */
    private $purchaseItemRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ProfitForMonthHandler
     */
    private $profitForMonthHandler;

    /**
     * @var PurchasesForMonthHandler
     */
    private $purchasesForMonthHandler;

    /**
     * @var RegisteredForMonthHandler
     */
    private $registeredForMonthHandler;

    public function __construct(
        PurchaseRepository $purchaseRepository,
        PurchaseItemRepository $purchaseItemRepository,
        UserRepository $userRepository,
        ProfitForMonthHandler $profitForMonthHandler,
        PurchasesForMonthHandler $purchasesForMonthHandler,
        RegisteredForMonthHandler $registeredForMonthHandler
    )
    {
        $this->purchaseRepository = $purchaseRepository;
        $this->purchaseItemRepository = $purchaseItemRepository;
        $this->userRepository = $userRepository;
        $this->profitForMonthHandler = $profitForMonthHandler;
        $this->purchasesForMonthHandler = $purchasesForMonthHandler;
        $this->registeredForMonthHandler = $registeredForMonthHandler;
    }

    public function handle(): VisitResult
    {
        $profitForYear = $this->purchaseRepository->retrieveTotalProfitForYearCompleted([ViaContext::BY_ADMIN]);
        // Cast values to expected types.
        $profitForYear = array_map(function ($each) {
            return [
                'month' => (int)$each['month'],
                'year' => (int)$each['year'],
                'total' => (float)$each['total']
            ];
        }, $profitForYear);

        $purchasesForYear = $this->purchaseItemRepository->retrieveAmountForYearCompleted();
        // Cast values to expected types.
        $purchasesForYear = array_map(function ($each) {
            return [
                'month' => (int)$each['month'],
                'year' => (int)$each['year'],
                'amount' => (float)$each['amount']
            ];
        }, $purchasesForYear);

        $registeredForYear = $this->userRepository->retrieveCreatedForYear();
        // Cast values to expected types.
        $registeredForYear = array_map(function ($each) {
            return [
                'month' => (int)$each['month'],
                'year' => (int)$each['year'],
                'amount' => (float)$each['amount']
            ];
        }, $registeredForYear);

        $topPurchasedProducts = $this->purchaseItemRepository->retrieveTopPurchasedProductsCompleted(
            self::TOP_PURCHASED_PRODUCTS_MAX_POSITIONS
        );
        foreach ($topPurchasedProducts as $key => &$each) {
            $topPurchasedProducts[$key]['amount'] = (int)$each['amount'];
        }

        $now = new \DateTimeImmutable();
        $year = (int)$now->format('Y');
        $month = (int)$now->format('m');

        return (new VisitResult())
            ->setProfitForYear($profitForYear)
            ->setProfitForMonth($this->profitForMonthHandler->handle($year, $month))
            ->setPurchasesForYear($purchasesForYear)
            ->setPurchasesForMonth($this->purchasesForMonthHandler->handle($year, $month))
            ->setRegisteredForYear($registeredForYear)
            ->setRegisteredForMonth($this->registeredForMonthHandler->handle($year, $month))
            ->setTopPurchasedProducts($topPurchasedProducts)
            ->setTotalProfit($this->purchaseRepository->retrieveTotalProfitCompleted([ViaContext::BY_ADMIN]))
            ->setTotalPurchasesAmount($this->purchaseItemRepository->retrievePurchasesAmountCompleted())
            ->setFillBalanceAmount($this->purchaseRepository->retrieveFillBalanceAmountCompleted())
            ->setRegisteredUserAmount($this->userRepository->retrieveCreatedAmount())
            ->setYear($year)
            ->setMonth($month);
    }
}
