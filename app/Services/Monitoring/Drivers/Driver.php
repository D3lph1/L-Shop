<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

use App\Entity\Server;
use App\Services\Monitoring\MonitoringException;

/**
 * Interface Driver
 * The driver organizes interaction with the repository from which it is possible to obtain
 * online statistics. It can be either a game server or any database or another service
 * that provides access to this information.
 */
interface Driver
{
    /**
     * Gets the statistics of the current online for the given server.
     *
     * @param Server $server
     *
     * @return DTO Resultant data transfer object.
     * @throws MonitoringException
     */
    public function retrieve(Server $server): DTO;
}
