<?php
declare(strict_types = 1);

namespace App\Exceptions\Purchase;

use App\Exceptions\DomainException;
use Throwable;

class DoesNotExistsException extends DomainException
{
    public function __construct($purchase, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Purchase {$purchase} does not exists", $code, $previous);
    }
}
