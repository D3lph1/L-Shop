<?php

namespace App\Exceptions;

use Throwable;

class ItemNotFoundException extends \LogicException
{
    public function __construct($id, $code = 0, Throwable $previous = null)
    {
        $message = "Item with id {$id} not found";

        parent::__construct($message, $code, $previous);
    }
}
