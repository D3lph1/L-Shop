<?php
declare(strict_types = 1);

namespace App\Events\Item;

use App\Entity\Item;

class ItemWillBeDeletedEvent
{
    /**
     * @var Item
     */
    private $item;

    public function __construct(Item $item)
    {
        $this->item = $item;
    }

    /**
     * @return Item
     */
    public function getItem(): Item
    {
        return $this->item;
    }
}
