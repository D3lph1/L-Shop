<?php
declare(strict_types = 1);

namespace App\Exceptions\Category;

use App\Exceptions\DomainException;

class CategoryNotFoundException extends DomainException
{
    public static function byId(int $id): CategoryNotFoundException
    {
        return new CategoryNotFoundException("Category with id {$id} not found");
    }
}
