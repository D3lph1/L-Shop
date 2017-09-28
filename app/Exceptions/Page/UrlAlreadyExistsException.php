<?php
declare(strict_types = 1);

namespace App\Exceptions\Page;

use App\Exceptions\LogicException;
use Throwable;

/**
 * Class UrlAlreadyExistsException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Page
 */
class UrlAlreadyExistsException extends LogicException
{
    public function __construct(string $url, int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Page with url `$url` already exists", $code, $previous);
    }
}
