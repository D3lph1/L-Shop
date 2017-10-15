<?php
declare(strict_types = 1);

namespace App\Services\User;

use App\Exceptions\LogicException;
use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Container\Container;

/**
 * Class Balance
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\User
 */
class Balance
{
    public static function add(UserInterface $user, float $value)
    {
        self::check($value);
        self::repository()->incrementById($user->getId(), 'balance', $value);
        self::sentinel()->setUser(self::repository()->findById($user->getId()));
    }

    public static function sub(UserInterface $user, float $value)
    {
        self::check($value);
        self::repository()->incrementById($user->getId(), 'balance', -$value);
        self::sentinel()->setUser(self::repository()->findById($user->getId()));
    }

    private static function check(float $value)
    {
        if ($value <= 0) {
            throw new LogicException("Values ​​must be greater than 0 ($value given)");
        }
    }

    private static function repository(): UserRepositoryInterface
    {
        return Container::getInstance()->make(UserRepositoryInterface::class);
    }

    private static function sentinel(): Sentinel
    {
        return Container::getInstance()->make(Sentinel::class);
    }
}
