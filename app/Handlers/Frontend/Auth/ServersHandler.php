<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Auth;

use App\DataTransferObjects\Frontend\Auth\Server as ServerDTO;
use App\DataTransferObjects\Frontend\Auth\Servers;
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
     * @return Servers
     */
    public function servers(): Servers
    {
        /** @var Server[] $servers */
        $servers = $this->repository->findAll();

        $serverDTOs = [];
        foreach ($servers as $server) {
            if (
                $server->isEnabled() ||
                (
                    $this->auth->check() &&
                    $this->auth->getUser()->hasPermission(Permissions::SWITCH_SERVERS_STATE)
                )
            ) {
                $dto = new ServerDTO(
                    $server->getId(),
                    $server->getName(),
                    $server->isEnabled(),
                    'frontend.shop.catalog'
                );

                $serverDTOs[] = $dto;
            }
        }

        return (new Servers($serverDTOs))
            ->setCanServersCrud(
                $this->auth->check()
                    ? $this->auth->getUser()->hasPermission(Permissions::ADMIN_SERVERS_CRUD_ACCESS) : false
            )
            ->setCanEnableDisableServers(
                $this->auth->check()
                    ? $this->auth->getUser()->hasPermission(Permissions::SWITCH_SERVERS_STATE) : false
            );
    }
}
