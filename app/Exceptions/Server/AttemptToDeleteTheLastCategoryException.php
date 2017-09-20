<?php

namespace App\Exceptions\Server;

use App\Exceptions\LShopException;
use LogicException;

/**
 * Class AttemptToDeleteTheLastCategoryException
 * An exception is thrown if an attempt is made to delete the last category on given server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Exceptions\Server
 */
class AttemptToDeleteTheLastCategoryException extends LogicException implements LShopException
{
    //
}
