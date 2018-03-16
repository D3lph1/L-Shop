<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\Entity\Permission;
use App\Entity\User as Entity;

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

    public function __construct(Entity $user, string $skinFront, string $skinBack, ?string $cloakFront, ?string $cloakBack)
    {
        $this->user = $user;
        $this->skinFront = $skinFront;
        $this->skinBack = $skinBack;
        $this->cloakFront = $cloakFront;
        $this->cloakBack = $cloakBack;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        $roles = [];
        foreach ($this->user->getRoles() as $role) {
            $roles[] = $role->getName();
        }
        $permissions = [];
        /** @var Permission $permission */
        foreach ($this->user->getPermissions() as $permission) {
            $permissions[] = $permission->getName();
        }

        return [
            'id' => $this->user->getId(),
            'username' => $this->user->getUsername(),
            'email' => $this->user->getEmail(),
            'roles' => $roles,
            'permissions' => $permissions,
            'character' => [
                'skin' => [
                    'front' => $this->skinFront,
                    'back' => $this->skinBack,
                ],
                'cloak' => [
                    'front' => $this->cloakFront,
                    'back' => $this->cloakBack
                ]
            ]
        ];
    }
}
