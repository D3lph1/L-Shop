<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\Player;

use App\Services\Game\Permissions\LuckPerms\Entity\Player;
use Ramsey\Uuid\UuidInterface;

interface PlayerRepository
{
    public function create(Player $player): void;

    public function update(Player $player): void;

    public function deleteAll(): bool;

    public function findByUsername(string $username): ?Player;

    public function findByUuid(UuidInterface $uuid): ?Player;
}
