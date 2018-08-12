<?php
declare(strict_types = 1);

namespace App\Repository\Category;

use App\Entity\Category;

interface CategoryRepository
{
    public function create(Category $category): void;

    public function update(Category $category): void;

    public function remove(Category $category): void;

    public function deleteAll(): bool;

    public function find(int $id): ?Category;

    /**
     * @return Category[]
     */
    public function findAll(): array;
}
