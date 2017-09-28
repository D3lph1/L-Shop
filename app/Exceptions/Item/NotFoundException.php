<?php
declare(strict_types = 1);

namespace App\Exceptions\Item;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class NotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Item
 */
class NotFoundException extends RuntimeException
{
    public function __construct(int $itemId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Item with id `$itemId` not found", $code, $previous);
    }
}
