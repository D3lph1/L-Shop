<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Statistic\Show;

use App\Services\Response\JsonRespondent;

class VisitResult implements JsonRespondent
{
    /**
     * @var array
     */
    private $profitForYear;

    /**
     * @var array
     */
    private $profitForMonth;

    /**
     * @var array
     */
    private $purchasesForYear;

    /**
     * @var array
     */
    private $purchasesForMonth;

    /**
     * @var array
     */
    private $registeredForYear;

    /**
     * @var array
     */
    private $registeredForMonth;

    /**
     * @var array
     */
    private $topPurchasedProducts;

    /**
     * @var float
     */
    private $totalProfit;

    /**
     * @var int
     */
    private $totalPurchasesAmount;

    /**
     * @var int
     */
    private $fillBalanceAmount;

    /**
     * @var int
     */
    private $registeredUserAmount;

    /**
     * @var int
     */
    private $year;

    /**
     * @var int
     */
    private $month;

    /**
     * @param array $profitForYear
     *
     * @return VisitResult
     */
    public function setProfitForYear(array $profitForYear): VisitResult
    {
        $this->profitForYear = $profitForYear;

        return $this;
    }

    /**
     * @param array $profitForMonth
     *
     * @return VisitResult
     */
    public function setProfitForMonth(array $profitForMonth): VisitResult
    {
        $this->profitForMonth = $profitForMonth;

        return $this;
    }

    /**
     * @param array $purchasesForYear
     *
     * @return VisitResult
     */
    public function setPurchasesForYear(array $purchasesForYear): VisitResult
    {
        $this->purchasesForYear = $purchasesForYear;

        return $this;
    }

    /**
     * @param array $purchasesForMonth
     *
     * @return VisitResult
     */
    public function setPurchasesForMonth(array $purchasesForMonth): VisitResult
    {
        $this->purchasesForMonth = $purchasesForMonth;

        return $this;
    }

    /**
     * @param array $registeredForYear
     *
     * @return VisitResult
     */
    public function setRegisteredForYear(array $registeredForYear): VisitResult
    {
        $this->registeredForYear = $registeredForYear;

        return $this;
    }

    /**
     * @param array $registeredForMonth
     *
     * @return VisitResult
     */
    public function setRegisteredForMonth(array $registeredForMonth): VisitResult
    {
        $this->registeredForMonth = $registeredForMonth;

        return $this;
    }

    /**
     * @param mixed $topPurchasedProducts
     *
     * @return VisitResult
     */
    public function setTopPurchasedProducts($topPurchasedProducts)
    {
        $this->topPurchasedProducts = $topPurchasedProducts;

        return $this;
    }

    /**
     * @param float $totalProfit
     *
     * @return VisitResult
     */
    public function setTotalProfit(float $totalProfit): VisitResult
    {
        $this->totalProfit = $totalProfit;

        return $this;
    }

    /**
     * @param int $totalPurchasesAmount
     *
     * @return VisitResult
     */
    public function setTotalPurchasesAmount(int $totalPurchasesAmount): VisitResult
    {
        $this->totalPurchasesAmount = $totalPurchasesAmount;

        return $this;
    }

    /**
     * @param int $fillBalanceAmount
     *
     * @return VisitResult
     */
    public function setFillBalanceAmount(int $fillBalanceAmount): VisitResult
    {
        $this->fillBalanceAmount = $fillBalanceAmount;

        return $this;
    }

    /**
     * @param int $registeredUserAmount
     *
     * @return VisitResult
     */
    public function setRegisteredUserAmount(int $registeredUserAmount): VisitResult
    {
        $this->registeredUserAmount = $registeredUserAmount;

        return $this;
    }

    /**
     * @param int $year
     *
     * @return VisitResult
     */
    public function setYear(int $year): VisitResult
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @param int $month
     *
     * @return VisitResult
     */
    public function setMonth(int $month): VisitResult
    {
        $this->month = $month;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function response(): array
    {
        return [
            'profitForYear' => $this->profitForYear,
            'profitForMonth' => $this->profitForMonth,
            'purchasesForYear' => $this->purchasesForYear,
            'purchasesForMonth' => $this->purchasesForMonth,
            'registeredForYear' => $this->registeredForYear,
            'registeredForMonth' => $this->registeredForMonth,
            'topPurchasedProducts' => $this->topPurchasedProducts,
            'totalProfit' => $this->totalProfit,
            'totalPurchasesAmount' => $this->totalPurchasesAmount,
            'fillBalanceAmount' => $this->fillBalanceAmount,
            'registeredUserAmount' => $this->registeredUserAmount,
            'year' => $this->year,
            'month' => $this->month
        ];
    }
}
