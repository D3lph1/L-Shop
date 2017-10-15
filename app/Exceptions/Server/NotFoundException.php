<?php
declare(strict_types = 1);

namespace App\Exceptions\Server;

use App\Exceptions\DomainException;
use Throwable;

/**
 * Class NotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Server
 */
class NotFoundException extends DomainException
{
    public function __construct(int $serverId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Server with id `$serverId` not found", $code, $previous);
    }
}
