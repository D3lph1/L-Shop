<?php

if (!function_exists('s_get')) {
    /**
     * Get the setting value
     *
     * @param $key
     * @param null $default
     * @param bool $lower
     * @return string
     */
    function s_get($key, $default = null, $lower = false)
    {
        if ($lower) {
            return mb_strtolower(\Setting::get($key, $default));
        }

        return \Setting::get($key, $default);
    }
}

if (!function_exists('s_set')) {
    /**
     * Set the setting value
     *
     * @param $value
     */
    function s_set($value)
    {
        \Setting::set($value);
    }
}

if (!function_exists('s_save')) {
    /**
     * Save the settings
     */
    function s_save()
    {
        \Setting::save();
    }
}

if (!function_exists('is_auth')) {
    /**
     * Checking whether a user is logged in at the moment
     *
     * @return bool|\Cartalyst\Sentinel\Users\UserInterface
     */
    function is_auth()
    {
        return \Sentinel::check();
    }
}

if (!function_exists('access_mode_auth')) {

    function access_mode_auth()
    {
        return s_get('shop.access_mode', 'auth', true) === 'auth' ? true : false;
    }
}

if (!function_exists('access_mode_auth')) {
    /**
     * Checks shopping mode
     *
     * @return bool
     */
    function access_mode_auth()
    {
        return s_get('shop.access_mode', 'auth', true) === 'auth' ? true : false;
    }
}

if (!function_exists('access_mode_free')) {
    /**
     * Checks shopping mode
     *
     * @return bool
     */
    function access_mode_free()
    {
        return s_get('shop.access_mode', 'auth', true) === 'free' ? true : false;
    }
}

if (!function_exists('access_mode_any')) {
    /**
     * Checks shopping mode
     *
     * @return bool
     */
    function access_mode_any()
    {
        return s_get('shop.access_mode', 'auth', true) === 'any' ? true : false;
    }
}

if (!function_exists('is_enable')) {
    /**
     * Checks for the specific rights the shop
     *
     * @return bool
     */
    function is_enable($action)
    {
        return (bool)s_get($action);
    }
}

if (!function_exists('img_path')) {
    /**
     * Return path to images folder
     *
     * @return bool
     */
    function img_path($url)
    {
        return public_path("img/$url");
    }
}
