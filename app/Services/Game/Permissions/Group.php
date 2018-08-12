<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Group
 * Represents a permission group. The group is a convenient container for permission
 * and allows them to be conveniently manipulated.
 */
class Group
{
    /**
     * Name of default group.
     */
    public const DEFAULT = 'default';

    /**
     * Name of the current group.
     *
     * @var string
     */
    private $name;

    /**
     * A set of permissions that belong to this group.
     *
     * @var Collection
     */
    private $permissions;

    /**
     * @var Collection
     */
    private $parents;

    /**
     * @var \DateTimeImmutable|null
     */
    private $expireAt;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->permissions = new ArrayCollection();
        $this->parents = new ArrayCollection();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function getParents(): Collection
    {
        return $this->parents;
    }

    public function getExpireAt(): ?\DateTimeImmutable
    {
        return $this->expireAt;
    }

    public function setExpireAt(?\DateTimeImmutable $expireAt): Group
    {
        $this->expireAt = $expireAt;

        return $this;
    }
}
