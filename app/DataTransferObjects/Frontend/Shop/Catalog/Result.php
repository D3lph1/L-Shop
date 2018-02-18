<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop\Catalog;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class Result
{
    /**
     * @var Server
     */
    private $server;

    /**
     * @var Category|null
     */
    private $currentCategory;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var LengthAwarePaginator|null
     */
    private $paginator;

    public function __construct(Server $server, ?Category $currentCategory, array $products, ?LengthAwarePaginator $paginator)
    {
        $this->server = $server;
        $this->currentCategory = $currentCategory;
        $this->products = $products;
        $this->paginator = $paginator;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getCurrentCategory(): ?Category
    {
        return $this->currentCategory;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getPaginator(): ?LengthAwarePaginator
    {
        return $this->paginator;
    }
}
