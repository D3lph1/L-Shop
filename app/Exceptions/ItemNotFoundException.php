<?php
declare(strict_types = 1);

namespace App\Exceptions;

use Throwable;

/**
 * Class ItemNotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions
 */
class ItemNotFoundException extends LogicException
{
    public function __construct(int $id, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Item with id `$id` not found", $code, $previous);
    }
}
