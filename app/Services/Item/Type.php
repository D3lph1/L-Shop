<?php
declare(strict_types = 1);

namespace App\Services\Item;

/**
 * Class Type
 * Defines constants with item types.
 */
class Type
{
    /**
     * A sold item is a regular in-game item or block.
     */
    public const ITEM = 'item';

    /**
     * The item being sold is an in-game privilege or permission, permission group.
     */
    public const PERMGROUP = 'permgroup';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
