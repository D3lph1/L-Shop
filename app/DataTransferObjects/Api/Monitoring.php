<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Api;

use App\Services\Monitoring\Entity;

class Monitoring implements \JsonSerializable
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
            'server' => [
                'name' => $this->entity->getServer()->getName()
            ],
            'now' => $this->entity->getNow(),
            'total' => $this->entity->getTotal(),
            'isDisabled' => $this->entity->isDisabled(),
            'isFailed' => $this->entity->isFailed()
        ];
    }
}
