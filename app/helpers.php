<?php
declare(strict_types = 1);

/**
 * File with declaration (helpers) functions.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

if (!function_exists('s_get')) {
    /**
     * Get the setting value
     */
    function s_get(string $key, $default = null, bool $lower = false): string
    {
        if ($lower) {
            return mb_strtolower(\Setting::get($key, $default));
        }

        return \Setting::get($key, $default);
    }
}

if (!function_exists('s_set')) {
    /**
     * Set the option value.
     *
     * @param string|array $option Option name or array `option` => `value`
     * @param mixed        $value  Option value
     */
    function s_set($option, $value = null): void
    {
        \Setting::set($option, $value);
    }
}

if (!function_exists('s_save')) {
    /**
     * Save the settings.
     */
    function s_save(): void
    {
        \Setting::save();
    }
}

if (!function_exists('is_auth')) {
    /**
     * Checking whether a user is logged in at the moment.
     */
    function is_auth(): bool
    {
        return (bool)\Sentinel::check();
    }
}

if (!function_exists('is_admin')) {
    /**
     * Checks user for administrator rights.
     */
    function is_admin(): bool
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
     * Checks shopping mode.
     */
    function access_mode_auth(): bool
    {
        return s_get('shop.access_mode', 'auth', true) === 'auth' ? true : false;
    }
}

if (!function_exists('access_mode_guest')) {
    /**
     * Checks shopping mode.
     */
    function access_mode_guest(): bool
    {
        return s_get('shop.access_mode', 'auth', true) === 'guest' ? true : false;
    }
}

if (!function_exists('access_mode_any')) {
    /**
     * Checks shopping mode.
     */
    function access_mode_any(): bool
    {
        return s_get('shop.access_mode', 'auth', true) === 'any' ? true : false;
    }
}

if (!function_exists('is_enable')) {
    /**
     * Checks for the specific rights the shop.
     */
    function is_enable(string $action): bool
    {
        return (bool)s_get($action);
    }
}

if (!function_exists('img_path')) {
    /**
     * Return path to images folder.
     */
    function img_path(string $url): string
    {
        return public_path("img/$url");
    }
}

if (!function_exists('json_response')) {
    /**
     * Return filled json response object.
     */
    function json_response(string $status, array $data = []): JsonResponse
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
     * Adds an given sum to the user's account.
     */
    function refill_user_balance(float $sum, ?int $userId = null)
    {
        // TODO: Remove this func

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

if (!function_exists('humanize_month')) {

    function humanize_month(string $month): string
    {
        return strtr($month, __('content.months'));
    }
}

if (!function_exists('short_string')) {

    function short_string(string $string, int $length): string
    {
        if (mb_strlen($string) < $length) {
            return $string;
        }

        return mb_substr($string, 0, $length) . '...';
    }
}

if (!function_exists('dt')) {
    /**
     * dt - default time.
     * Formatted time to default format.
     *
     * @param string|Carbon $date
     *
     * @return string
     */
    function dt($date): string
    {
        $format = 'd-m-Y H:i:s';

        if ($date instanceof Carbon) {
            return $date->format($format);
        }

        return (new Carbon($date))->format($format);
    }
}

if (!function_exists('build_ban_message')) {
    /**
     * @param null|Carbon $until
     * @param null|string $reason
     *
     * @return string
     */
    function build_ban_message(?Carbon $until = null, ?string $reason = null): string
    {
        if (is_null($until) and is_null($reason)) {
            return __('messages.admin.users.edit.block.successful.permanently.without_reason');
        }

        if (is_null($until) and !is_null($reason)) {
            return __('messages.admin.users.edit.block.successful.permanently.with_reason',
                compact('reason'));
        }

        if (!is_null($until) and is_null($reason)) {
            return __('messages.admin.users.edit.block.successful.temporarily.without_reason',
                compact('until'));
        }

        if (!is_null($until) and !is_null($reason)) {
            return __('messages.admin.users.edit.block.successful.temporarily.with_reason',
                compact('until', 'reason'));
        }

        // Unreachable, return statement for IDE.
        return '';
    }
}

if (!function_exists('username')) {

    function username(): ?string
    {
        if (!is_auth()) {
            return null;
        }

        return \Sentinel::getUser()->getUserLogin();
    }
}

if (!function_exists('cloak_exists')) {

    function cloak_exists(string $username): bool
    {
        return file_exists(config('l-shop.profile.cloaks.path') . '/' . $username . '.png');
    }
}

if (!function_exists('get_server_by_id')) {

    function get_server_by_id(iterable $servers, int $id)
    {
        foreach ($servers as $server) {
            if ($server->id === $id) {
                return $server;
            }
        }
    }
}

if (!function_exists('colorize_rcon')) {

    function colorize_rcon(string $string): string
    {
        preg_match_all("/[^§&]*[^§&]|[§&][0-9a-z][^§&]*/", $string, $brokenUpStr);
        $returnStr = "<span>";
        foreach ($brokenUpStr as $results){
            $ending = '';
            foreach ($results as $individual){
                $code = preg_split("/[&§][0-9a-z]/", $individual);
                preg_match("/[&§][0-9a-z]/", $individual, $prefix);
                if (isset($prefix[0])){
                    $actualcode = substr($prefix[0], 1);
                    switch ($actualcode){
                        case "1":
                            $returnStr = $returnStr. '<span style="color: #0000AA;">';
                            $ending = $ending ."</span>";
                            break;
                        case "2":
                            $returnStr = $returnStr.'<span style="color: #00AA00;""">';
                            $ending =$ending ."</span>";
                            break;
                        case "3":
                            $returnStr = $returnStr.'<span style="color: #00AAAA">';
                            $ending = $ending ."</span>";
                            break;
                        case "4":
                            $returnStr = $returnStr.'<span style="color: #AA0000">';
                            $ending =$ending ."</span>";
                            break;
                        case "5":
                            $returnStr = $returnStr.'<span style="color: #AA00AA">';
                            $ending =$ending . "</span>";
                            break;
                        case "6":
                            $returnStr = $returnStr.'<span style="color: #FFAA00">';
                            $ending =$ending ."</span>";
                            break;
                        case "7":
                            $returnStr = $returnStr.'<span style="color: #AAAAAA">';
                            $ending = $ending ."</span>";
                            break;
                        case "8":
                            $returnStr = $returnStr.'<span style="color: #555555">';
                            $ending =$ending ."</span>";
                            break;
                        case "9":
                            $returnStr = $returnStr.'<span style="color: #5555FF">';
                            $ending =$ending . "</span>";
                            break;
                        case "a":
                            $returnStr = $returnStr.'<span style="color: #55FF55">';
                            $ending =$ending . "</span>";
                            break;
                        case "b":
                            $returnStr = $returnStr.'<span style="color: #55FFFF">';
                            $ending = $ending . "</span>";
                            break;
                        case "c":
                            $returnStr = $returnStr.'<span style="color: #FF5555">';
                            $ending =$ending ."</span>";
                            break;
                        case "d":
                            $returnStr = $returnStr.'<span style="color: #FF55FF">';
                            $ending =$ending . "</span>";
                            break;
                        case "e":
                            $returnStr = $returnStr.'<span style="color: #FFFF55">';
                            $ending = $ending . "</span>";
                            break;
                        case "f":
                            $returnStr = $returnStr.'<span style="color: #333">';
                            $ending =$ending ."</span>";
                            break;
                        case "l":
                            if (strlen($individual) > 2){
                                $returnStr = $returnStr.'<span style="font-weight:bold;">';
                                $ending = "</span>" . $ending;
                                break;
                            }
                            break;
                        case "m":
                            if (strlen($individual)>2){
                                $returnStr = $returnStr. '<span style="text-decoration: line-through;">';
                                $ending = "</span>" . $ending;
                                break;
                            }
                            break;
                        case "n":
                            if (strlen($individual)>2){
                                $returnStr = $returnStr.'<span style="text-decoration: underline;">';
                                $ending = "</span>" . $ending;
                                break;
                            }
                            break;
                        case "o":
                            if (strlen($individual)>2){
                                $returnStr = $returnStr.'<i>';
                                $ending ="</i>".$ending;
                                break;
                            }
                            break;
                        case "r":
                            $returnStr = $returnStr.$ending;
                            $ending = '';
                            break;
                    }

                    if (isset($code[1])){
                        $returnStr = $returnStr . $code[1];
                        if (isset($ending) && strlen($individual) > 2){
                            $returnStr = $returnStr.$ending;
                            $ending = '';
                        }
                    }
                }
                else{
                    $returnStr = $returnStr . $individual;
                }
            }
        }

        return $returnStr . '</span>';
    }
}
