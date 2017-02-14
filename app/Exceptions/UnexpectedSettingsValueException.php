<?php

namespace App\Exceptions;

use Exception;

class UnexpectedSettingsValueException extends \Exception
{
    public function __construct($message = "")
    {
        $message = "Value '$message' is unexpected";
        parent::__construct($message);
    }
}
