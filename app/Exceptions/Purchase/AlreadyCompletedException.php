<?php
declare(strict_types = 1);

namespace App\Exceptions\Purchase;

use App\Entity\Purchase;
use App\Exceptions\LogicException;
use Throwable;

class AlreadyCompletedException extends LogicException
{
    public function __construct(Purchase $purchase, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Purchase {$purchase} already completed", $code, $previous);
    }
}
