<?php

/**
 *  File with declaration helpers-functions
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */

if (!function_exists('s_get')) {
    /**
     * Get the setting value
     *
     * @param      $key
     * @param null $default
     * @param bool $lower
     *
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
     * Set the option value
     *
     * @param string|array $option Option name or array `option` => `value`
     * @param mixed  $value  Option value
     */
    function s_set($option, $value = null)
    {
        \Setting::set($option, $value);
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

if (!function_exists('is_admin')) {
    /**
     * Checks user for administrator rights
     *
     * @return bool
     */
    function is_admin()
    {
        if (is_auth()) {
            $user = \Sentinel::getUser();

            return $user->hasAccess(['user.admin']);
        }

        return false;
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

if (!function_exists('access_mode_guest')) {
    /**
     * Checks shopping mode
     *
     * @return bool
     */
    function access_mode_guest()
    {
        return s_get('shop.access_mode', 'auth', true) === 'guest' ? true : false;
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

if (!function_exists('json_response')) {
    /**
     * Return filled json response object
     *
     * @param       $status
     * @param array $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function json_response($status, $data = [])
    {
        $response = [
            'status' => $status
        ];

        if (count($data) > 0) {
            return response()->json(array_merge($response, $data));
        }

        return response()->json($response);
    }
}

if (!function_exists('refill_user_balance')) {
    /**
     * Adds an given sum to the user's account
     *
     * @param int  $sum
     * @param null $userId
     */
    function refill_user_balance($sum, $userId = null)
    {
        if (is_null($userId)) {
            if (is_auth()) {
                $balance = \Sentinel::getUser()->getBalance();
                \Sentinel::update(\Sentinel::getUser(), [
                    'balance' => $balance + $sum
                ]);
            } else {
                throw new LogicException('User not auth');
            }
        } else {
            $user = \Sentinel::getUserRepository()->findById($userId);
            $balance = $user->getBalance();
            \Sentinel::update($user, [
                'balance' => $balance + $sum
            ]);
        }
    }
}

if (!function_exists('humanize_perm_duration')) {
    /**
     * @param int $interval
     *
     * @return array
     */
    function humanize_perm_duration($interval)
    {
        if ($interval < 60) {
            return [
                'original' => $interval,
                'short' => $interval,
                'name' => 'second',
                'title' => 'сек.'
            ];
        }

        if ($interval >= 60 and $interval < 3600) {
            return [
                'original' => $interval,
                'short' => $interval / 60,
                'name' => 'minute',
                'title' => 'мин.'
            ];
        }

        if ($interval >= 3600 and $interval < 86400) {
            return [
                'original' => $interval,
                'short' => $interval / 3600,
                'name' => 'hour',
                'title' => 'час.'
            ];
        }

        if ($interval > 86400) {
            return [
                'original' => $interval,
                'short' => $interval / 86400,
                'name' => 'day',
                'title' => 'дн.'
            ];
        }

        return [];
    }
}

if (!function_exists('unhumanize_perm_duration')) {
    /**
     * @param int $interval
     * @param string $measure
     *
     * @return mixed
     */
    function unhumanize_perm_duration($interval, $measure)
    {
        if ($measure == 'second') {
            return $interval;
        }else if ($measure == 'minute') {
            return $interval * 60;
        }else if ($measure == 'hour') {
            return $interval * 3600;
        }else if ($measure == 'day') {
            return $interval * 86400;
        }

        return $interval;
    }
}
