<?php
declare(strict_types = 1);

namespace App\Exceptions\News;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class DisabledException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\News
 */
class DisabledException extends LogicException
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("News function disabled", $code, $previous);
    }
}
