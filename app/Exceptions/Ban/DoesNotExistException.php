<?php
declare(strict_types = 1);

namespace App\Exceptions\Ban;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($ban = null)
    {
        if ($ban !== null) {
            $message = "Ban {$ban} does not exist";
        } else {
            $message = '';
        }

        parent::__construct($message, 0, null);
    }
}
