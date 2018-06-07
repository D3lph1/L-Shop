<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

use App\DataTransferObjects\Admin\Users\Edit\User as UserDTO;
use App\Entity\Permission;
use App\Entity\Role;
use App\Services\Response\JsonRespondent;

class RenderResult implements JsonRespondent
{
    /**
     * @var UserDTO
     */
    private $user;

    /**
     * @var Role[]
     */
    private $roles = [];

    /**
     * @var Permission[]
     */
    private $permissions = [];

    /**
     * @var bool
     */
    private $cartAccess = false;

    /**
     * @var bool
     */
    private $purchasesAccess = false;

    /**
     * @var bool
     */
    private $canCompletePurchase = false;

    public function setUser(UserDTO $user): RenderResult
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param Role[] $roles
     *
     * @return RenderResult
     */
    public function setRoles(array $roles): RenderResult
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @param Permission[] $permissions
     *
     * @return RenderResult
     */
    public function setPermissions(array $permissions): RenderResult
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * @param bool $canCompletePurchase
     *
     * @return RenderResult
     */
    public function setCanCompletePurchase(bool $canCompletePurchase): RenderResult
    {
        $this->canCompletePurchase = $canCompletePurchase;

        return $this;
    }

    /**
     * @param bool $purchasesAccess
     *
     * @return RenderResult
     */
    public function setPurchasesAccess(bool $purchasesAccess): RenderResult
    {
        $this->purchasesAccess = $purchasesAccess;

        return $this;
    }

    /**
     * @param bool $cartAccess
     *
     * @return RenderResult
     */
    public function setCartAccess(bool $cartAccess): RenderResult
    {
        $this->cartAccess = $cartAccess;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'user' => $this->user,
            'roles' => $this->roles,
            'permissions' => $this->permissions,
            'cartAccess' => $this->cartAccess,
            'canCompletePurchase' => $this->canCompletePurchase,
            'purchasesAccess' => $this->purchasesAccess
        ];
    }
}
