<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\News;

use App\Services\Response\JsonRespondent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult implements JsonRespondent
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
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'news' => $this->news
        ];
    }
}
