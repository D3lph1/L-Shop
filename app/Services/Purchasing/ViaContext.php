<?php
declare(strict_types = 1);

namespace App\Services\Purchasing;

/**
 * Class ViaContext
 * Defines the constants of the purchase completion context.
 */
final class ViaContext
{
    /**
     * Purchase was completed immediately after the creation. For example, because the
     * user had enough money on the account.
     */
    public const QUICK = null;

    /**
     * Purchase was completed from the administration panel manually.
     */
    public const BY_ADMIN = '@admin';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
