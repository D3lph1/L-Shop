<?php
declare(strict_types = 1);

namespace App\Models\Role;

use App\Services\User\Permissions\Permissions;

/**
 * Interface RoleInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Role
 */
interface RoleInterface
{
    public function getPermissionsManager(): Permissions;


    public function getId(): int;

    public function setSlug(string $slug): RoleInterface;

    public function getSlug(): string;

    public function setName(string $name): RoleInterface;

    public function getName(): string;

    public function getPermissions(): array;
}
