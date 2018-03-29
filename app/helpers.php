<?php
declare(strict_types = 1);

namespace App;

function permission_middleware(string $permission): string
{
    return "permission:{$permission}";
}

function auth_middleware(string $mode): string
{
    return "auth:{$mode}";
}
