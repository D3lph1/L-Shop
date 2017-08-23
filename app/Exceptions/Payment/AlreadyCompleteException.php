<?php

namespace App\Exceptions\Payment;

use App\Exceptions\LShopException;

/**
 * Class AlreadyCompleteException
 * An exception is thrown when trying to complete an already completed payment.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment
 */
class AlreadyCompleteException extends \LogicException implements LShopException
{
    //
}
