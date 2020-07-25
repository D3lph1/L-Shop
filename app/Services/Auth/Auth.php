<?php
declare(strict_types = 1);

namespace App\Services\Auth;

use App\Entity\User;

/**
 * Методы аудентификации с точки зрения клиента
 * @package App\Services\Auth
 */
interface Auth
{
    /**
     * Аудентифицируем пользователя от имени пользователя и паролем
     *
     * @param string $username
     * @param string $password
     * @param bool   $remember If true, the user session will exist even after the browser is closed.
     *
     * @return bool Результат аудентификации пользователя
     */
    public function authenticate(string $username, string $password, bool $remember = false): bool;

    /**
     * AАудентификация с данным объектом БД
     *
     * @param User $user     Пользователь, который требуется для создания
     * @param bool $remember Если да, то сессия будет сущетсовать даже когда закроется браузер
     *
     * @return mixed
     * @see Authenticator::authenticateQuick()
     */
    public function authenticateQuick(User $user, bool $remember): bool;

    /**
     * Регистрация нового пользователя в системе
     *
     * @param User $user     Сущность пользователя
     * @param bool $activate Если да, то пользователь будет активирован немедленно после регистрации
     *
     * @return User
     * @throws \Exception
     */
    public function register(User $user, bool $activate = false): User;

    /**
     * Возвращаем сохраненного в сессии пользователя, иначе null
     *
     * @return User|null
     */
    public function getUser(): ?User;

    /**
     * Проверка, что сессия не пустая
     *
     * @return bool
     */
    public function check(): bool;

    /**
     * Удаляем пользователя уничтожением сессии на конкретном устройстве
     *
     * @param bool $anywhere Если да, уничтожаем пользователя на всех устройствах
     */
    public function logout(bool $anywhere = false): void;
}
