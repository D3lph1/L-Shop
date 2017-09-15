<?php
declare(strict_types = 1);

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function search(string $search, array $searchSpecials): iterable;
}
