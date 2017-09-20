<?php
declare(strict_types = 1);

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function truncate(): void;
}
