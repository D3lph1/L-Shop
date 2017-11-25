<?php
declare(strict_types = 1);

namespace App\Services\Items;

/**
 * Class Type
 * Defines the available item types.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Services\Items
 */
final class Type
{
    /**
     * The item is a common game item or block.
     */
    public const ITEM = 'item';

    /**
     * Item is a privilege.
     */
    public const PERMGROUP = 'permgroup';

    private function __construct()
    {
        //
    }
}
