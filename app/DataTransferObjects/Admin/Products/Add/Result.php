<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Add;

class Result
{
    /**
     * @var Item[]
     */
    private $items;

    /**
     * @var Server[]
     */
    private $servers;

    public function __construct(array $items, array $servers)
    {
        $this->items = $items;
        $this->servers = $servers;
    }

    /**
     * @return Item[]
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
}
