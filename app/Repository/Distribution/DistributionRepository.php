<?php
declare(strict_types = 1);

namespace App\Repository\Distribution;

use App\Entity\Distribution;
use App\Entity\Server;
use App\Entity\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface DistributionRepository
{
    public function create(Distribution $distribution): void;

    public function update(Distribution $distribution): void;

    public function findByUserPaginated(User $user, int $page, int $perPage): LengthAwarePaginator;

    public function findByUserPaginatedWithOrder(User $user, int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function findByUserAndServerPaginated(User $user, Server $server, int $page, int $perPage): LengthAwarePaginator;

    public function findByUserAndServerPaginatedWithOrder(User $user, Server $server, int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator;

    public function deleteAll(): bool;
}
