<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Items\EditList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Result
{
    private $paginator;

    private $items = [];

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->items[] = new Item($item);
        }
    }

    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
