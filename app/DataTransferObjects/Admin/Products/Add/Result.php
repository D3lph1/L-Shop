<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Add;

use App\Services\Response\JsonRespondent;

class Result implements JsonRespondent
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
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'items' => $this->items,
            'servers' => $this->servers
        ];
    }
}
