<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Statistic\Purchases\Purchase;
use App\Entity\Permission;
use App\Entity\Role;
use App\Entity\User as Entity;
use App\Services\Auth\BanManager;

class User implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $user;

    /**
     * @var string
     */
    private $skinFront;

    /**
     * @var string
     */
    private $skinBack;

    /**
     * @var string
     */
    private $cloakFront;

    /**
     * @var string
     */
    private $cloakBack;

    /**
     * @var bool
     */
    private $skinDefault;

    /**
     * @var bool
     */
    private $cloakExists;

    /**
     * @var string|null
     */
    private $activatedAt;

    /**
     * @var bool
     */
    private $banned;

    /**
     * @var BanManager
     */
    private $banManager;

    public function __construct(Entity $user, BanManager $banManager)
    {
        $this->user = $user;
        $this->banManager = $banManager;
    }

    public function setSkinFront(string $skinFront): User
    {
        $this->skinFront = $skinFront;

        return $this;
    }

    public function setSkinBack(string $url): User
    {
        $this->skinBack = $url;

        return $this;
    }

    public function setCloakFront(?string $url): User
    {
        $this->cloakFront = $url;

        return $this;
    }

    public function setCloakBack(?string $url): User
    {
        $this->cloakBack = $url;

        return $this;
    }

    public function setSkinDefault(bool $isSkinDefault): User
    {
        $this->skinDefault = $isSkinDefault;

        return $this;
    }

    public function setCloakExists(bool $isCloakExists): User
    {
        $this->cloakExists = $isCloakExists;

        return $this;
    }

    public function setActivatedAt(?string $activatedAt): User
    {
        $this->activatedAt = $activatedAt;

        return $this;
    }

    public function setBanned(bool $isBanned): User
    {
        $this->banned = $isBanned;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $roles = [];
        /** @var Role $role */
        foreach ($this->user->getRoles() as $role) {
            $roles[] = $role->getName();
        }
        $permissions = [];
        /** @var Permission $permission */
        foreach ($this->user->getPermissions() as $permission) {
            $permissions[] = $permission->getName();
        }

        $bans = [];
        /** @var \App\Entity\Ban $ban */
        foreach ($this->user->getBans() as $ban) {
            $bans[] = new Ban($ban, $this->banManager->isExpired($ban));
        }

        return [
            'id' => $this->user->getId(),
            'username' => $this->user->getUsername(),
            'email' => $this->user->getEmail(),
            'balance' => $this->user->getBalance(),
            'roles' => $roles,
            'permissions' => $permissions,
            'character' => [
                'skin' => [
                    'front' => $this->skinFront,
                    'back' => $this->skinBack,
                    'default' => $this->skinDefault
                ],
                'cloak' => [
                    'front' => $this->cloakFront,
                    'back' => $this->cloakBack,
                    'exists' => $this->cloakExists
                ]
            ],
            'activatedAt' => $this->activatedAt,
            'bans' => $bans,
            'banned' => $this->banned
        ];
    }
}
