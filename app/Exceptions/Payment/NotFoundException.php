<?php

namespace App\Exceptions\Payment;

use App\Exceptions\LShopException;

/**
 * Class NotFoundException
 * An exception intended for cases where you can not select from the payment database.
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Payment
 */
class NotFoundException extends \RuntimeException implements LShopException
{
    //
}
