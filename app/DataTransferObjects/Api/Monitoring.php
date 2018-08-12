<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Api;

use App\Services\Monitoring\Statistic;

class Monitoring implements \JsonSerializable
{
    /**
     * @var Statistic
     */
    private $entity;

    public function __construct(Statistic $entity)
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
