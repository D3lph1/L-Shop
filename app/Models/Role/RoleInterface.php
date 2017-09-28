<?php
declare(strict_types = 1);

namespace App\Models\Role;

/**
 * Interface RoleInterface
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Models\Role
 */
interface RoleInterface
{
    public function getId(): int;

    public function getSlug(): string;

    public function getName(): string;

    public function getPermissions(): array;
}
