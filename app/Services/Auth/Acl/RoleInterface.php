<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

interface RoleInterface extends HasPermissions
{
    public function getName(): string;
}
