<?php
declare(strict_types=1);

namespace App\DataTransferObjects\Frontend\Profile\Cart;

use App\Services\Response\JsonRespondent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult implements JsonRespondent
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Distribution[]
     */
    private $items = [];

    /**
     * @var Server[]
     */
    private $servers;

    /**
     * ListResult constructor.
     *
     * @param LengthAwarePaginator $paginator
     * @param Server[]             $servers
     */
    public function __construct(LengthAwarePaginator $paginator, array $servers)
    {
        $this->paginator = $paginator;
        foreach ($paginator->items() as $item) {
            $this->items[] = new Distribution($item);
        }
        $this->servers = $servers;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginator(): LengthAwarePaginator
    {
        return $this->paginator;
    }

    /**
     * @return Distribution[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @return Server[]
     */
    public function getServers(): array
    {
        return $this->servers;
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'items' => $this->items,
            'servers' => $this->servers
        ];
    }
}
