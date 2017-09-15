<?php

namespace App\Exceptions\News;

use App\Exceptions\LShopException;
use RuntimeException;
use Throwable;

class NotFoundExceptions extends RuntimeException implements LShopException
{
    public function __construct(int $newsId, $code = 0, Throwable $previous = null)
    {
        $message = "News with id `$newsId` not found";

        parent::__construct($message, $code, $previous);
    }
}
