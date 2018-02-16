<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\DataTransferObjects\Frontend\Auth\Server as ServerDTO;
use App\Entity\Server;
use App\Repository\Server\ServerRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;

class ServersHandler
{
    /**
     * @var ServerRepository
     */
    private $repository;

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(ServerRepository $repository, Auth $auth)
    {
        $this->repository = $repository;
        $this->auth = $auth;
    }

    /**
     * @return ServerDTO[]
     */
    public function servers(): array
    {
        /** @var Server[] $servers */
        $servers = $this->repository->findAll();
        if ($this->auth->check()) {
            if ($this->auth->getUser()->hasPermission(Permissions::VIEWING_DISABLED_SERVERS)) {
                $serverDTOs = [];
                foreach ($servers as $server) {
                    $serverDTOs[] = new ServerDTO(
                        $server->getId(),
                        $server->getName(),
                        $server->isEnabled(),
                        'frontend.shop.catalog'
                    );
                }

                return $serverDTOs;
            }
        }

        $serverDTOs = [];
        foreach ($servers as $server) {
            if ($server->isEnabled()) {
                $serverDTOs[] = new ServerDTO(
                    $server->getId(),
                    $server->getName(),
                    $server->isEnabled(),
                    'frontend.shop.catalog'
                );
            }
        }

        return $serverDTOs;
    }
}
