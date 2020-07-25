<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;
use App\Services\Auth\Session\Session;

/**
 * Методы аудентфикации с точки зрения сервера-аудентификации
 * @package App\Services\Auth
 */
interface Authenticator
{
    /**
     * Аудентифицирует пользователя по переданному пользователю и паролю
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember Если да, то сессия будет существовать когда бразуер закроется
     *
     * @return Session Объект сессии аудентфицированного пользователя
     */
    public function authenticate(string $username, string $password, bool $remember): Session;

    /**
     * Простая аудентфикация по пользователю и паролю
     *
     * @param User $user
     * @param bool $remember
     *
     * @return Session
     */
    public function authenticateQuick(User $user, bool $remember): Session;
}
