<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Statistic\Purchases;

use App\Services\Response\JsonRespondent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationResult implements JsonRespondent
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
    protected $canComplete;

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($paginator->items() as $item) {
            $this->items[] = new Purchase($item);
        }
    }

    public function setCanComplete(bool $value): PaginationResult
    {
        $this->canComplete = $value;

        return $this;
    }

    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'items' => $this->items,
            'canComplete' => $this->canComplete
        ];
    }
}
