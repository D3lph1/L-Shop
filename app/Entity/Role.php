<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Services\Auth\Acl\PermissionTrait;
use App\Services\Auth\Acl\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles")
 */
class Role implements RoleInterface
{
    use PermissionTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="roles")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Permission", mappedBy="roles", cascade={"persist"})
     */
    private $permissions;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Role
    {
        $this->name = $name;

        return $this;
    }

    public function addPermission(Permission $permission): Role
    {
        $this->permissions->add($permission);

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): Role
    {
        $this->users->add($user);

        return $this;
    }

    /**
     * @return Collection|Permission[]
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, name="%s")',
            self::class,
            $this->getId(),
            $this->getName()
        );
    }
}
