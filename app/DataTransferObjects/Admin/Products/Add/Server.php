<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Products\Add;

use App\Entity\Server as Entity;

class Server implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $server;

    public function __construct(Entity $server)
    {
        $this->server = $server;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        $categories = [];
        foreach ($this->server->getCategories() as $category) {
            $categories[] = new Category($category);
        }

        return [
            'name' => $this->server->getName(),
            'categories' => $categories
        ];
    }
}
