<?php
declare(strict_types = 1);

namespace App\Exceptions\Server;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($server)
    {
        parent::__construct("Server {$server} does not exist", 0, null);
    }
}
