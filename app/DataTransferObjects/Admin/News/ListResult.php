<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\News;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var News[]
     */
    private $news = [];

    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->news[] = new News($item);
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
     * @return News[]
     */
    public function getNews(): array
    {
        return $this->news;
    }
}
