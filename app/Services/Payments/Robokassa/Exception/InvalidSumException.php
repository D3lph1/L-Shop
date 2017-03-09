<?php

/**
 * This file is part of Robokassa package.
 *
 * (c) 2014 IDM Agency (http://idma.ru)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services\Payments\Robokassa\Exception;

/**
 * Class InvalidSumException
 *
 * @author JhaoDa <jhaoda@gmail.com>
 *
 * @package Idma\Robokassa\Exception
 */
class InvalidSumException extends PaymentException {
    public function __construct($message = '', $code = 0, \Exception $previous = null) {
        parent::__construct('Invoice sum is required and cannot be less or equals zero.', $code, $previous);
    }
}
