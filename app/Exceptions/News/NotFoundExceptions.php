<?php
declare(strict_types = 1);

namespace App\Exceptions\News;

use App\Exceptions\RuntimeException;
use Throwable;

class NotFoundExceptions extends RuntimeException
{
    public function __construct(int $newsId, $code = 0, Throwable $previous = null)
    {
        $message = "News with id `$newsId` not found";

        parent::__construct($message, $code, $previous);
    }
}
