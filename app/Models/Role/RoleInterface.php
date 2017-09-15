<?php
declare(strict_types = 1);

namespace App\Models\Role;

interface RoleInterface
{
    public function getId(): int;

    public function getSlug(): string;

    public function getName(): string;

    public function getPermissions(): array;
}
