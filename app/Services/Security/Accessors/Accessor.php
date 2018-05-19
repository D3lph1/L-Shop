<?php
declare(strict_types = 1);

namespace App\Services\Security\Accessors;

/**
 * Interface Accessor
 * Checks if the user has access to a resource.
 */
interface Accessor
{
    /**
     * Returns true - the user has the right to perform this action, false otherwise.
     *
     * @return bool
     */
    public function resolve(): bool;
}
