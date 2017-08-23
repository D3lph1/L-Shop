<?php

namespace App\Exceptions;

use Throwable;

/**
 * Class ItemNotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions
 */
class ItemNotFoundException extends \LogicException implements LShopException
{
    public function __construct($id, $code = 0, Throwable $previous = null)
    {
        $message = "Item with id {$id} not found";

        parent::__construct($message, $code, $previous);
    }
}
