<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Statistic\Purchases;

use App\DataTransferObjects\Frontend\Profile\Purchases\Item;
use App\Entity\Purchase as Entity;
use App\Services\DateTime\Formatting\JavaScriptFormatter;
use App\Services\Purchasing\ViaContext;

class Purchase implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $entity;

    /**
     * @var Item[]
     */
    private $items = [];

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
        foreach ($this->entity->getItems() as $item) {
            $this->items[] = new Item($item);
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->entity->getId(),
            'cost' => $this->entity->getCost(),
            'createdAt' => (new JavaScriptFormatter())->format($this->entity->getCreatedAt()),
            'completedAt' => $this->entity->getCompletedAt() !== null ?
                (new JavaScriptFormatter())->format($this->entity->getCompletedAt()) : null,
            'via' => [
                'quick' => $this->entity->getVia() === ViaContext::QUICK,
                'byAdmin' => $this->entity->getVia() === ViaContext::BY_ADMIN,
                'value' => $this->entity->getVia()
            ],
            'items' => $this->items,
            'player' => $this->entity->getPlayer() ?? null,
            'user' => [
                'id' => $this->entity->getUser() !== null ? $this->entity->getUser()->getId() : null,
                'username' => $this->entity->getUser() !== null ? $this->entity->getUser()->getUsername() : null
            ]
        ];
    }
}
