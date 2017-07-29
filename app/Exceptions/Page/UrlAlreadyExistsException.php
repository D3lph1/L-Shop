<?php

namespace App\Exceptions\Page;

use Throwable;

class UrlAlreadyExistsException extends \LogicException
{
    public function __construct($url, $code = 0, Throwable $previous = null)
    {
        parent::__construct($url, $code, $previous);
    }
}
