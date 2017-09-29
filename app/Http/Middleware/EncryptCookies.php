<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

/**
 * Class EncryptCookies
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'message'
    ];
}
