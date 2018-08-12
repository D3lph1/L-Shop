<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Purchases;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Purchase[]
     */
    private $items = [];

    /**
     * @var bool
     */
    protected $canComplete = false;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($paginator->items() as $item) {
            $this->items[] = new Purchase($item);
        }
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @return Purchase[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function setCanComplete(bool $value): ListResult
    {
        $this->canComplete = $value;

        return $this;
    }

    public function canComplete(): bool
    {
        return $this->canComplete;
    }
}
