<?php
declare(strict_types = 1);

namespace App\Services\Monitoring\Drivers;

use App\Entity\Server;

interface Driver
{
    public function retrieve(Server $server): DTO;
}
