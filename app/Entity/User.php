<?php
declare(strict_types = 1);

namespace App\Entity;

use App\Exceptions\InvalidArgumentException;
use App\Services\Auth\Acl\HasPermissions;
use App\Services\Auth\Acl\HasRoles;
use App\Services\Auth\Acl\PermissionTrait;
use App\Services\Auth\Acl\RoleTrait;
use App\Services\User\Balance\Transactor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users", indexes={
 *     @ORM\Index(name="username_idx", columns={"username"}),
 *     @ORM\Index(name="email_idx", columns={"email"})
 * })
 * @ORM\HasLifecycleCallbacks
 */
class User implements HasRoles, HasPermissions
{
    use RoleTrait, PermissionTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="username", type="string", length=32, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="password", type="string", length=60)
     */
    private $password;

    /**
     * @ORM\Column(name="balance", type="float", nullable=false, unique=false)
     */
    private $balance = 0;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Role", mappedBy="users", cascade={"persist", "merge"})
     */
    private $roles;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Permission", mappedBy="users")
     */
    private $permissions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Activation", mappedBy="user", cascade={"remove"})
     */
    private $activations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Persistence", mappedBy="user", cascade={"remove"})
     */
    private $persistences;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ban", mappedBy="user", cascade={"persist", "merge"})
     */
    private $bans;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reminder", mappedBy="user", cascade={"remove"})
     */
    private $reminders;

    /**
     * @ORM\Column(name="created_at", type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    public function __construct(string $username, string $email, string $password)
    {
        $this->setUsername($username);
        $this->setEmail($email);
        $this->setPassword($password);
        $this->roles = new ArrayCollection();
        $this->permissions = new ArrayCollection();
        $this->activations = new ArrayCollection();
        $this->persistences = new ArrayCollection();
        $this->bans = new ArrayCollection();
        $this->reminders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * It is not recommended to use this method directly. Instead, use {@see Transactor}.
     *
     * @param float $balance
     *
     * @return User
     */
    public function setBalance(float $balance): User
    {
        if ($balance < 0) {
            throw new InvalidArgumentException('The argument $balance must be greater than or equal to zero');
        }
        $this->balance = $balance;

        return $this;
    }

    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addRole(Role $role): User
    {
        $this->roles->add($role);

        return $this;
    }

    public function getRoles(): Collection
    {
        return $this->roles;
    }

    public function addReminder(Reminder $reminder): User
    {
        $this->reminders->add($reminder);

        return $this;
    }

    public function getActivations(): Collection
    {
        return $this->activations;
    }

    public function getPersistences(): Collection
    {
        return $this->persistences;
    }

    public function addBan(Ban $ban): User
    {
        $this->bans->add($ban);

        return $this;
    }

    public function getBans(): Collection
    {
        return $this->bans;
    }

    public function getReminders(): Collection
    {
        return $this->reminders;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @return string Object string representation.
     * @example App\Entity\User(id=1, username="Admin", email="admin@example.com", balance=1000)
     */
    public function __toString(): string
    {
        return sprintf(
            '%s(id=%d, username="%s", email="%s", balance=%F)',
            self::class,
            $this->getId(),
            $this->getUsername(),
            $this->getEmail(),
            $this->getBalance()
        );
    }
}
