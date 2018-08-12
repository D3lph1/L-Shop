<?php
declare(strict_types = 1);

namespace App\Composers\Constructors;

use App\Handlers\Frontend\Auth\ServersHandler;

class ServersBlockConstructor
{
    public function construct(): array
    {
        return app(ServersHandler::class)->servers();
    }
}
