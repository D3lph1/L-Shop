<?php
declare(strict_types = 1);

namespace App\Exceptions\Payment;

use App\Exceptions\RuntimeException;

/**
 * Class UnableToCompleteException
 * An exception intended for those cases, for some reason, can not complete the payment.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment
 */
class UnableToCompleteException extends RuntimeException
{
    //
}
