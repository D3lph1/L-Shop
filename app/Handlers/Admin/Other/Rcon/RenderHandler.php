<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Other\Rcon;

use App\DataTransferObjects\Admin\Other\Rcon\Server;
use App\Repository\Server\ServerRepository;

class RenderHandler
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    public function __construct(ServerRepository $serverRepository)
    {
        $this->serverRepository = $serverRepository;
    }

    public function handle(): array
    {
        $servers = [];
        foreach ($this->serverRepository->findAll() as $server) {
            $servers[] = new Server($server);
        }

        return $servers;
    }
}
