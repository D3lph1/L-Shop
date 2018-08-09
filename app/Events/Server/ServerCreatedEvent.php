<?php
declare(strict_types = 1);

namespace App\Events\Server;

use App\Entity\Server;

class ServerCreatedEvent
{
    /**
     * @var Server
     */
    private $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return Server
     */
    public function getServer(): Server
    {
        return $this->server;
    }
}
