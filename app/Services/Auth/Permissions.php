<?php
declare(strict_types = 1);

namespace App\Services\Auth;

/**
 * Class Permissions
 * Defines available permissions.
 * <p>For example:</p>
 * <code>
 *  $user->hasPermission(Permissions::ADMIN_ITEMS_CRUD_ACCESS);
 * </code>
 */
class Permissions
{
    /**
     * Allows the user to see disabled servers in the server list and enable disable their.
     */
    public const SWITCH_SERVERS_STATE = 'switch_servers_state';

    /**
     * Allows the user to access a page with a purchase history (Profile->Information->Purchase History).
     */
    public const PROFILE_PURCHASE_HISTORY_ACCESS = 'purchase_history_access';

    /**
     * Allows the user to access a page with a game cart (Profile->Information->Game cart).
     */
    public const PROFILE_GAME_CART_ACCESS = 'game_cart_access';

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
     * Gives the user the right to use the `profile->settings` section.
     */
    public const PROFILE_SETTINGS_ACCESS = 'profile_settings_access';

    /**
     * Gives the user the right to use the `admin->control->basic` section.
     */
    public const ADMIN_CONTROL_BASIC_ACCESS = 'admin_control_basic_access';

    /**
     * Gives the user the right to use the `admin->control->payments settings` section.
     */
    public const ADMIN_CONTROL_PAYMENTS_ACCESS = 'admin_control_payments_access';

    /**
     * Gives the user the right to use the `admin->control->API settings` section.
     */
    public const ADMIN_CONTROL_API_ACCESS = 'admin_control_api_access';

    /**
     * Gives the user the right to use the `admin->control->security` section.
     */
    public const ADMIN_CONTROL_SECURITY_ACCESS = 'admin_control_security_access';

    /**
     * Gives the user the right to use the `admin->control->optimization` section.
     */
    public const ADMIN_CONTROL_OPTIMIZATION_ACCESS = 'admin_control_optimization_access';

    /**
     * Allows the user to add/edit/delete servers and categories.
     */
    public const ADMIN_SERVERS_CRUD_ACCESS = 'admin_servers_crud_access';

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
     * Allows the user to access to rcon console.
     */
    public const ADMIN_OTHER_RCON_ACCESS = 'admin_other_rcon_access';

    /**
     * Allows the user to access to debug page.
     */
    public const ADMIN_OTHER_DEBUG_ACCESS = 'admin_other_debug_access';

    /**
     * Allows to show shop statistic.
     */
    public const ADMIN_STATISTIC_SHOW_ACCESS = 'admin_statistic_show_access';

    /**
     * Allows to purchases history in admin panel.
     */
    public const ADMIN_STATISTIC_PURCHASES_ACCESS = 'admin_statistic_purchases_access';

    /**
     * Allow the user to complete purchase.
     */
    public const ALLOW_COMPLETE_PURCHASES = 'allow_complete_purchases';

    /**
     * Allows the user to access the `admin->information->about` section
     */
    public const ADMIN_INFORMATION_ABOUT_ACCESS = 'admin_information_about_access';

    /**
     * Allows the user to access the application while the maintenance mode is on.
     */
    public const ACCESS_WHILE_MAINTENANCE = 'access_while_maintenance';

    /**
     * Private constructor because this class contains only constants.
     */
    private function __construct()
    {
    }
}
