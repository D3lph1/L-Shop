<?php

namespace App\Exceptions\Payment\Interkassa;

use Throwable;

/**
 * Class UnknownCheckoutException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions\Payment\Interkassa
 */
class UnknownCheckoutException extends \RuntimeException
{
    public function __construct($checkoutId, $code = 0, Throwable $previous = null)
    {
        $expected = s_get('payment.method.interkassa.checkout_id');
        $message = "Checkout $expected expected, $checkoutId given";

        parent::__construct($message, $code, $previous);
    }
}
