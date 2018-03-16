<?php
declare(strict_types = 1);

namespace App\Services\Auth;

class Permissions
{
    public const VIEWING_DISABLED_SERVERS = 'viewing_disabled_servers';

    /**
     * Ability to set skins.
     */
    public const ALLOW_SET_SKINS = 'allow_set_skins';

    /**
     * The ability to set skins, regardless of whether or not it is possible to skins at all.
     */
    public const ALLOW_SET_SKINS_IMPORTANT = 'allow_set_skins_important';

    /**
     * Ability to set hd skins.
     */
    public const ALLOW_SET_HD_SKINS = 'allow_set_hd_skins';

    /**
     * The ability to set hd skins, regardless of whether or not it is possible to skins at all.
     */
    public const ALLOW_SET_HD_SKINS_IMPORTANT = 'allow_set_hd_skins_important';

    /**
     * Ability to set cloaks.
     */
    public const ALLOW_SET_CLOAKS = 'allow_set_cloaks';

    /**
     * The ability to set cloaks, regardless of whether or not it is possible to skins at all.
     */
    public const ALLOW_SET_CLOAKS_IMPORTANT = 'allow_set_cloaks_important';

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
     * Allows the user to add/edit/delete items.
     */
    public const ADMIN_ITEMS_CRUD_ACCESS = 'admin_items_crud_access';

    /**
     * Allows the user to add/edit/delete products.
     */
    public const ADMIN_PRODUCTS_CRUD_ACCESS = 'admin_products_crud_access';

    /**
     * Allows the user to add/edit/delete news.
     */
    public const ADMIN_NEWS_CRUD_ACCESS = 'admin_news_crud_access';

    /**
     * Allows the user to add/edit/delete pages.
     */
    public const ADMIN_PAGES_CRUD_ACCESS = 'admin_pages_crud_access';

    /**
     * Allows the user to add/edit/delete users.
     */
    public const ADMIN_USERS_CRUD_ACCESS = 'admin_users_crud_access';

    /**
     * Allows to show shop statistic.
     */
    public const ADMIN_STATISTIC_SHOW_ACCESS = 'admin_statistic_show_access';

    /**
     * Allows the user to access the `admin->information->about` section
     */
    public const ADMIN_INFORMATION_ABOUT_ACCESS = 'admin_information_about_access';

    private function __construct()
    {
    }
}
