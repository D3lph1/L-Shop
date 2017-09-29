<?php
declare(strict_types = 1);

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as BaseTrimmer;

/**
 * Class TrimStrings
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Middleware
 */
class TrimStrings extends BaseTrimmer
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array
     */
    protected $except = [
        'password',
        'password_confirmation',
    ];
}
