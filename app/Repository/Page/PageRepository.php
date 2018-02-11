<?php
declare(strict_types = 1);

namespace App\Repository\Page;

use App\Entity\Page;

interface PageRepository
{
    public function create(Page $page): void;

    public function deleteAll(): bool;

    public function findByUrl(string $url): ?Page;
}
