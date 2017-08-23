<?php

namespace App\Exceptions\Page;

use Throwable;
use App\Exceptions\LShopException;

/**
 * Class UrlAlreadyExistsException
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Exceptions\Page
 */
class UrlAlreadyExistsException extends \LogicException implements LShopException
{
    public function __construct($url, $code = 0, Throwable $previous = null)
    {
        parent::__construct($url, $code, $previous);
    }
}
