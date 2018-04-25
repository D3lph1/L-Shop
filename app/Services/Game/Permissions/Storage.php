<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Entity\User;

/**
 * Interface Storage
 * Represents a storage of permissions, groups and other entities of game permissions.
 */
interface Storage
{
    /**
     * Gets the player and repositories and converts the received storage entity
     * to the subject domain entity {@see Player}. Returns null - if the
     * specified player is not found.
     *
     * @param User $user The user whose player you want to receive.
     *
     * @return Player|null
     */
    public function retrievePlayer(User $user): ?Player;

    /**
     * Gets the group and repositories and converts the received storage entity
     * to the subject domain entity {@see Group}. Returns null - if the
     * specified group is not found.
     *
     * @param string $name Name of the group you want to receive.
     *
     * @return Group|null
     */
    public function retrieveGroup(string $name): ?Group;
}
