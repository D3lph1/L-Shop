<?php
declare(strict_types = 1);

namespace App\Exceptions\News;

use App\Exceptions\DomainException;

class NewsNotFoundException extends DomainException
{
    public static function byId(int $id): NewsNotFoundException
    {
        return new NewsNotFoundException("News with id {$id} not found");
    }
}
