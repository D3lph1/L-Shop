<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Pages;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Page[]
     */
    private $pages = [];

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->pages[] = new Page($item);
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
     * @return Page[]
     */
    public function getPages(): array
    {
        return $this->pages;
    }
}
