<?php

namespace App\Exceptions;

/**
 * Class UnexpectedSettingsValueException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions
 */
class UnexpectedSettingsValueException extends \Exception implements LShopException
{
    public function __construct($message = "")
    {
        $message = "Value '$message' is unexpected";
        parent::__construct($message);
    }
}
