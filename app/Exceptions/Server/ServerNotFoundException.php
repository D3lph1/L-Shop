<?php
declare(strict_types = 1);

namespace App\Exceptions\Server;

use App\Exceptions\DomainException;

class ServerNotFoundException extends DomainException
{
    public static function byId(int $id): ServerNotFoundException
    {
        return new ServerNotFoundException("Server with id {$id} not found");
    }
}
