<?php
declare(strict_types = 1);

namespace App\Exceptions\Enchantment;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($enchantment = null)
    {
        if ($enchantment !== null) {
            $message = "Enchantment {$enchantment} does not exist";
        } else {
            $message = '';
        }

        parent::__construct($message, 0, null);
    }
}
