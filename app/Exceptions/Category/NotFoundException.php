<?php
declare(strict_types = 1);

namespace App\Exceptions\Category;

use App\Exceptions\RuntimeException;
use Throwable;

/**
 * Class NotFoundException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Category
 */
class NotFoundException extends RuntimeException
{
    public function __construct(int $categoryId, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            "Category with id `$categoryId` not found",
            $code,
            $previous
        );
    }
}
