<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\EditList;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Result
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Product[]
     */
    private $products = [];

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->products[] = new Product($item);
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
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
