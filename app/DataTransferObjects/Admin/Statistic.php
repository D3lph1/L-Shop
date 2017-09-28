<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin;

/**
 * Class Statistic
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin
 */
class Statistic
{
    /**
     * @var float
     */
    private $profit;

    /**
     * @var iterable
     */
    private $completedForYear;

    /**
     * @var int
     */
    private $currentMonth;

    /**
     * @var string
     */
    private $currentMonthHumanized;

    public function setCompletedForYear(iterable $data): self
    {
        $this->completedForYear = $data;

        return $this;
    }

    public function getCompletedForYear(): iterable
    {
        return $this->completedForYear;
    }

    public function setProfit(float $profit): self
    {
        $this->profit = $profit;

        return $this;
    }

    public function getProfit(): float
    {
        return $this->profit;
    }

    public function setCurrentMonth(int $currentMonth): self
    {
        $this->currentMonth = $currentMonth;

        return $this;
    }

    public function getCurrentMonth(): int
    {
        return $this->currentMonth;
    }

    public function setCurrentMonthHumanized(string $word): self
    {
        $this->currentMonthHumanized = $word;

        return $this;
    }

    public function getCurrentMonthHumanized(): string
    {
        return $this->currentMonthHumanized;
    }
}
