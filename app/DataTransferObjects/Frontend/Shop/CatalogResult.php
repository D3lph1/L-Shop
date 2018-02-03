<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop;

use App\Entity\Category;
use App\Entity\Server;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CatalogResult
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
     * @var LengthAwarePaginator
     */
    private $products;

    public function __construct(Server $server, ?Category $currentCategory, LengthAwarePaginator $products)
    {
        $this->server = $server;
        $this->currentCategory = $currentCategory;
        $this->products = $products;
    }

    public function getServer(): Server
    {
        return $this->server;
    }

    public function getCurrentCategory(): ?Category
    {
        return $this->currentCategory;
    }

    public function getProducts(): LengthAwarePaginator
    {
        return $this->products;
    }
}
