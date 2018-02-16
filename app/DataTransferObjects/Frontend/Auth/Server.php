<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Auth;

class Server implements \JsonSerializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $route;

    public function __construct(int $id, string $name, bool $enabled, string $route)
    {
        $this->id = $id;
        $this->name = $name;
        $this->enabled = $enabled;
        $this->route = $route;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'enabled' => $this->isEnabled(),
            'route' => $this->getRoute()
        ];
    }
}
