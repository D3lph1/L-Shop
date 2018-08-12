<?php
declare(strict_types = 1);

namespace App\Services\Auth\Acl;

interface PermissionInterface
{
    public function getName(): string;
}
