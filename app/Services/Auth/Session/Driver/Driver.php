<?php
declare(strict_types = 1);

namespace App\Services\Auth\Session\Driver;

use App\Entity\Persistence;

/**
 * Interface Driver
 * The session store driver. The driver is used to interact with the session storage.
 * The essence that the driver uses is persistence code.
 *
 * @see Persistence::$code
 */
interface Driver
{
    /**
     * Gets persistence code from the storage.
     *
     * @return null|string
     */
    public function get(): ?string;

    /**
     * Sets persistence code in the storage.
     *
     * @param string $persistenceCode
     */
    public function set(string $persistenceCode): void;

    /**
     * Clears storage by removing persistence code.
     */
    public function forget(): void;
}
