<?php
declare(strict_types = 1);

namespace App\Services\Item\Enchantment;

/**
 * Class Enchantments
 * Defines constants enchanted. The value of the constant is the in-game identifier of
 * the enchantment.
 */
class Enchantments
{
    // ** Armour **

    public const PROTECTION = 0;

    public const FIRE_PROTECTION = 1;

    public const FEATHER_FALLING = 2;

    public const BLAST_PROTECTION = 3;

    public const PROJECTILE_PROTECTION = 4;

    public const RESPIRATION = 5;

    public const AQUA_AFFINITY = 6;

    public const THORNS = 7;

    // ** Weapons **

    public const SHARPNESS = 16;

    public const SMITE = 17;

    public const BANE_OF_ARTHROPODS = 18;

    public const KNOCKBACK = 19;

    public const  FIRE_ASPECT = 20;

    public const LOOTING = 21;

    // ** Tools **

    public const EFFICIENCY = 32;

    public const SILK_TOUCH = 33;

    public const FORTUNE = 35;

    // ** Bows **

    public const POWER = 48;

    public const PUNCH = 49;

    public const FLAME = 50;

    public const INFINITY = 51;

    // ** Everything **

    public const UNBREAKING = 34;


    private function __construct()
    {
    }
}
