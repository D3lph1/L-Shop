<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Services\Auth\Acl\PermissionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="permissions")
 */
class Permission implements PermissionInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", length=64, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="permissions")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", inversedBy="permissions")
     */
    private $roles;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->users = new ArrayCollection();
        $this->roles = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Permission
    {
        $this->name = $name;

        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addRole(Role $role): Permission
    {
        $this->roles->add($role);

        return $this;
    }

    public function detachRoles(): Permission
    {
        $this->roles->clear();

        return $this;
    }
}
