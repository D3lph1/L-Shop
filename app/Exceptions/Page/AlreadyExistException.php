<?php
declare(strict_types = 1);

namespace App\Exceptions\Page;

use App\Exceptions\DomainException;

class AlreadyExistException extends DomainException
{
    public function __construct(string $url)
    {
        parent::__construct("Page with url `{$url}` already exists", 0, null);
    }
}
