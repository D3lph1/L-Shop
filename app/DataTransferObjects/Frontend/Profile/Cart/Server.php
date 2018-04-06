<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Cart;

use App\Entity\Server as Entity;

class Server implements \JsonSerializable
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
        return [
            'id' => $this->entity->getId(),
            'text' => $this->entity->getName()
        ];
    }
}
