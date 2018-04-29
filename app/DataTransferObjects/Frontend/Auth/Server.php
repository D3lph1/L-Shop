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

    /**
     * @var bool
     */
    private $canServersCrud;

    /**
     * @var bool
     */
    private $canEnableDisableServers;

    public function __construct(int $id, string $name, bool $enabled, string $route)
    {
        $this->id = $id;
        $this->name = $name;
        $this->enabled = $enabled;
        $this->route = $route;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'enabled' => $this->enabled,
            'route' => $this->route
        ];
    }
}
