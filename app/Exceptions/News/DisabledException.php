<?php
declare(strict_types = 1);

namespace App\Exceptions\News;

use App\Exceptions\LShopException;
use LogicException;
use Throwable;

class DisabledException extends LogicException implements LShopException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("News function disabled", $code, $previous);
    }
}
