<?php
declare(strict_types = 1);

/**
 * This file is part of Robokassa package.
 *
 * (c) 2014 IDM Agency (http://idma.ru)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Exceptions\Payment\Robokassa;

use App\Exceptions\Exception;
use App\Exceptions\LShopException;

/**
 * Class PaymentException
 *
 * @author JhaoDa <jhaoda@gmail.com>
 * @package Idma\Robokassa\Exception
 */
class PaymentException extends Exception implements LShopException
{
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        $message = $message ? $message : 'Unknown payment exception';

        parent::__construct($message, $code, $previous);
    }
}
