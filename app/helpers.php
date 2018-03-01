<?php
declare(strict_types = 1);

namespace App;

function permission_middleware(string $permission): string
{
    return "permission:{$permission}";
}
