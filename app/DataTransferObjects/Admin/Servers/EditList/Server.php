<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Servers\EditList;

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
        $categories = [];
        foreach ($this->entity->getCategories() as $category) {
            $categories[] = new Category($category);
        }

        return [
            'id' => $this->entity->getId(),
            'name' => $this->entity->getName(),
            'categories' => $categories
        ];
    }
}
