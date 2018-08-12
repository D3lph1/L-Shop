<?php
declare(strict_types = 1);

namespace App\Exceptions\Page;

use App\Exceptions\DomainException;

class PageNotFoundException extends DomainException
{
    public static function byId(int $id): PageNotFoundException
    {
        return new PageNotFoundException("Page with id {$id} not found");
    }

    public static function byUrl(string $url): PageNotFoundException
    {
        return new PageNotFoundException("Page with url \"{$url}\" not found");
    }
}
