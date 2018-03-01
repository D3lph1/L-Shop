<?php
declare(strict_types = 1);

namespace App\Exceptions\Item;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($item = null)
    {
        if ($item !== null) {
            $message = "Item {$item} does not exist";
        } else {
            $message = '';
        }

        parent::__construct($message, 0, null);
    }
}
