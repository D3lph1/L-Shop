<?php
declare(strict_types = 1);

namespace App\Services\Item;

/**
 * Class Type
 * Defines constants with item types.
 */
final class Type
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
     * This type represents an in-game currency.
     */
    public const CURRENCY = 'currency';

    /**
     * The item of this type is a region. By purchasing products of a similar type, the player
     * becomes the owner of the sold region.
     */
    public const REGION_OWNER = 'region_owner';

    /**
     * The item of this type is a region. By purchasing a product of this type, the player becomes
     * a member of the selling region.
     */
    public const REGION_MEMBER = 'region_member';

    /**
     * An object with the COMMAND type is a command that will be executed on the server when the
     * purchased products are delivered to the player.
     */
    public const COMMAND = 'command';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
