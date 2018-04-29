<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Auth;

class Servers implements \JsonSerializable
{
    /**
     * @var Server[]
     */
    private $servers;

    /**
     * @var bool
     */
    private $canServersCrud = false;

    /**
     * @var bool
     */
    private $canEnableDisableServers = false;

    /**
     * Servers constructor.
     *
     * @param Server[] $servers
     */
    public function __construct(array $servers)
    {
        $this->servers = $servers;
    }

    public function setCanServersCrud(bool $canServersCrud): Servers
    {
        $this->canServersCrud = $canServersCrud;

        return $this;
    }

    public function setCanEnableDisableServers(bool $canEnableDisableServers): Servers
    {
        $this->canEnableDisableServers = $canEnableDisableServers;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return [
            'servers' => $this->servers,
            'canServersCrud' => $this->canServersCrud,
            'canEnableDisableServers' => $this->canEnableDisableServers
        ];
    }
}
