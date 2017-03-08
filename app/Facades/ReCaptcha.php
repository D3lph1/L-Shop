<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ReCaptcha
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Facades
 */
class ReCaptcha extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'recaptcha';
    }
}
