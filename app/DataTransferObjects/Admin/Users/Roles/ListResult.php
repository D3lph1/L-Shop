<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Roles;

use App\Entity\Permission;
use App\Services\Response\JsonRespondent;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ListResult implements JsonRespondent
{
    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * @var Role[]
     */
    private $roles = [];

    /**
     * @var array
     */
    private $permissions;

    /**
     * ListResult constructor.
     * @param LengthAwarePaginator $paginator
     * @param Permission[] $permissions
     */
    public function __construct(LengthAwarePaginator $paginator, array $permissions)
    {
        $this->paginator = $paginator;
        foreach ($this->paginator->items() as $item) {
            $this->roles[] = new Role($item);
        }

        foreach ($permissions as $permission) {
            $this->permissions[] = $permission->getName();
        }
    }

    /**
     * @inheritDoc
     */
    public function response(): array
    {
        return [
            'paginator' => $this->paginator,
            'roles' => $this->roles,
            'permissions' => $this->permissions
        ];
    }
}
