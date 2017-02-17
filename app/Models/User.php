<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;

/**
 * Class User
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Models
 */
class User extends EloquentUser
{
    protected $fillable = [
        'username',
        'email',
        'password',
        'last_name',
        'first_name',
        'permissions',
        'balance'
    ];

    protected $loginNames = [
        'username',
        'email'
    ];

    public function getBalance()
    {
        return $this->balance;
    }
}
