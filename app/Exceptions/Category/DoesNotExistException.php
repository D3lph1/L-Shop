<?php
declare(strict_types = 1);

namespace App\Exceptions\Category;

use App\Exceptions\DomainException;

class DoesNotExistException extends DomainException
{
    public function __construct($category = null)
    {
        if ($category !== null) {
            $message = "Category {$category} does not exist";
        } else {
            $message = '';
        }

        parent::__construct($message, 0, null);
    }
}
