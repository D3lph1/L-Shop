<?php
declare(strict_types = 1);

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Message
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Facades
 */
class Message extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'message';
    }
}
