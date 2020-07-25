<?php
declare(strict_types = 1);

namespace App\Services\Auth\Hashing;

/**
 * Interface Hasher
 * Hasher используется для хеширования паролей и проверки валидности пароля
 */
interface Hasher
{
    /**
     * Создает и возвращает хеш переданного пароля
     *
     * @param string $plainPassword
     *
     * @return string
     */
    public function make(string $plainPassword): string;

    /**
     * Сравнивает простой пароль с хешем пароля
     *
     * @param string $plainPassword
     * @param string $hashedPassword
     *
     * @return bool Результат сранения. Да - совпадают
     */
    public function check(string $plainPassword, string $hashedPassword): bool;
}
