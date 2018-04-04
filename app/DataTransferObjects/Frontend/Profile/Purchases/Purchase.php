<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Purchases;

use App\Entity\Purchase as Entity;
use App\Services\DateTime\Formatting\JavaScriptFormatter;

class Purchase implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $items = [];
        foreach ($this->entity->getItems() as $item) {
            $items[] = new Item($item);
        }

        return [
            'id' => $this->entity->getId(),
            'cost' => $this->entity->getCost(),
            'createdAt' => (new JavaScriptFormatter())->format($this->entity->getCreatedAt()),
            'completedAt' => $this->entity->getCompletedAt() !== null ?
                (new JavaScriptFormatter())->format($this->entity->getCompletedAt()) : null,
            'items' => $items
        ];
    }
}
