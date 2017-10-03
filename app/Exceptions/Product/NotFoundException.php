<?php
declare(strict_types = 1);

namespace App\Exceptions\Product;

use App\Exceptions\DomainException;
use Throwable;

/**
 * Class NotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Product
 */
class NotFoundException extends DomainException
{
    public function __construct(int $productId, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Product with id `$productId` not found", $code, $previous);
    }
}
