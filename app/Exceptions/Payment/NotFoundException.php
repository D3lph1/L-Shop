<?php
declare(strict_types = 1);

namespace App\Exceptions\Payment;

use App\Exceptions\DomainException;
use Throwable;

/**
 * Class NotFoundException
 * An exception intended for cases where you can not select from the payment database.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment
 */
class NotFoundException extends DomainException
{
    public function __construct(int $paymentId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Payment with id `$paymentId` not found", $code, $previous);
    }
}
