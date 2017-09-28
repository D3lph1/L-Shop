<?php
declare(strict_types = 1);

namespace App\Exceptions\Payment;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class AlreadyCompleteException
 * An exception is thrown when trying to complete an already completed payment.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment
 */
class AlreadyCompletedException extends LogicException
{
    public function __construct(int $paymentId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Payment with id `$paymentId` already completed", $code, $previous);
    }
}
