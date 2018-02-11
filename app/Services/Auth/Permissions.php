<?php
declare(strict_types = 1);

namespace App\Services\Auth;

class Permissions
{
    public const VIEWING_DISABLED_SERVERS = 'viewing_disabled_servers';

    /**
     * Ability to set hd skins.
     */
    public const ALLOW_SET_HD_SKINS = 'allow_set_hd_skins';

    /**
     * The ability to set hd skins, regardless of whether or not it is possible to skins at all.
     */
    public const ALLOW_SET_HD_SKINS_IMPORTANT = 'allow_set_hd_skins_important';

    /**
     * Ability to set hd cloaks.
     */
    public const ALLOW_SET_HD_CLOAKS = 'allow_set_hd_cloaks';

    /**
     * The ability to set hd cloaks, regardless of whether or not it is possible to cloaks at all.
     */
    public const ALLOW_SET_HD_CLOAKS_IMPORTANT = 'allow_set_hd_cloaks_important';

    /**
     * Gives the user the right to use the `admin->control->basic` section
     */
    public const ADMIN_CONTROL_BASIC_ACCESS = 'admin_control_basic_access';

    /**
     * Allows the user to access the `admin->information->about` section
     */
    public const ADMIN_INFORMATION_ABOUT_ACCESS = 'admin_information_about_access';

    private function __construct()
    {
    }
}
