<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Statistic\Purchases;

use App\Services\Infrastructure\Response\JsonRespondent;
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

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($paginator->items() as $item) {
            $this->items[] = new Purchase($item);
        }
    }

    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'items' => $this->items
        ];
    }
}
