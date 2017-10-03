<?php
declare(strict_types = 1);

namespace App\Services\User;

use App\Exceptions\LogicException;
use App\Models\User\UserInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Container\Container;

class Balance
{
    public static function add(UserInterface $user, float $value)
    {
        self::check($value);
        self::repository()->incrementById($user->getId(), 'balance', $value);
    }

    public static function sub(UserInterface $user, float $value)
    {
        self::check($value);
        self::repository()->incrementById($user->getId(), 'balance', -$value);
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
}
