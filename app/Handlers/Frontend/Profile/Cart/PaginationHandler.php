<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Cart;

use App\DataTransferObjects\Frontend\Profile\Cart\ListResult;
use App\DataTransferObjects\Frontend\Profile\Cart\Server;
use App\Exceptions\InvalidArgumentException;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Distribution\DistributionRepository;
use App\Repository\Server\ServerRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;

class PaginationHandler
{
    private const PER_PAGE = 25;

    /**
     * @var array
     */
    private $availableOrders = ['distribution.id', 'purchaseItem.amount', 'item.name', 'server.name'];

    /**
     * @var DistributionRepository
     */
    private $distributionRepository;

    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var Auth
     */
    private $auth;

    public function __construct(
        DistributionRepository $distributionRepository,
        ServerRepository $serverRepository,
        Auth $auth)
    {
        $this->distributionRepository = $distributionRepository;
        $this->serverRepository = $serverRepository;
        $this->auth = $auth;
    }

    /**
     * @param int         $page
     * @param int|null    $serverId
     * @param null|string $orderBy
     * @param bool        $descending
     *
     * @return ListResult
     *
     * @throws ServerNotFoundException
     */
    public function handle(int $page, ?int $serverId, ?string $orderBy, bool $descending): ListResult
    {
        if (!empty($orderBy) && !in_array($orderBy, $this->availableOrders)) {
            throw new InvalidArgumentException('Argument $orderBy has illegal value');
        }

        $server = null;
        if ($serverId !== null) {
            $server = $this->serverRepository->find($serverId);
            if ($server === null) {
                throw ServerNotFoundException::byId($serverId);
            }
        }

        if ($orderBy !== null) {
            if ($serverId === null) {
                $paginator = $this->distributionRepository->findbyUserPaginatedWithOrder(
                    $this->auth->getUser(),
                    $page,
                    $orderBy,
                    $descending,
                    self::PER_PAGE
                );
            } else {
                $paginator = $this->distributionRepository->findByUserAndServerPaginatedWithOrder(
                    $this->auth->getUser(),
                    $server,
                    $page,
                    $orderBy,
                    $descending,
                    self::PER_PAGE
                );
            }
        } else {
            if ($serverId === null) {
                $paginator = $this->distributionRepository->findByUserPaginated(
                    $this->auth->getUser(),
                    $page,
                    self::PER_PAGE
                );
            } else {
                $paginator = $this->distributionRepository->findByUserAndServerPaginated(
                    $this->auth->getUser(),
                    $server,
                    $page,
                    self::PER_PAGE
                );
            }
        }

        return new ListResult($paginator, $this->servers());
    }

    private function servers(): array
    {
        $servers = [];

        /** @var \App\Entity\Server $server */
        foreach ($this->serverRepository->findAll() as $server) {
            if (!$server->isEnabled()) {
                if ($this->auth->getUser()->hasPermission(Permissions::SWITCH_SERVERS_STATE)) {
                    $servers[] = new Server($server);
                }
            } else {
                $servers[] = new Server($server);
            }
        }

        return $servers;
    }
}
