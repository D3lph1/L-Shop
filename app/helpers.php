<?php
declare(strict_types=1);

/**
 * File with declaration (helpers) functions.
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 */

use App\Models\Server\ServerInterface;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

/**
 * Get the setting value
 */
function s_get(string $key, $default = null, bool $lower = false)
{
    if ($lower) {
        return mb_strtolower(\Setting::get($key, $default));
    }

    return \Setting::get($key, $default);
}

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

/**
 * Save the settings.
 */
function s_save(): void
{
    \Setting::save();
}

/**
 * Checking whether a user is logged in at the moment.
 */
function is_auth(): bool
{
    return (bool)\Sentinel::check();
}

/**
 * Checks user for administrator rights.
 */
function is_admin(): bool
{
    if (is_auth()) {
        /** @var \App\Models\User\UserInterface $user */
        $user = \Sentinel::getUser();

        return $user->getPermissionsManager()->hasAccess(['user.admin']);
    }

    return false;
}

/**
 * Checks shopping mode.
 */
function access_mode_auth(): bool
{
    return s_get('shop.access_mode', 'auth', true) === \App\Services\Auth\AccessMode::AUTH;
}

/**
 * Checks shopping mode.
 */
function access_mode_guest(): bool
{
    return s_get('shop.access_mode', 'auth', true) === \App\Services\Auth\AccessMode::GUEST;
}

/**
 * Checks shopping mode.
 */
function access_mode_any(): bool
{
    return s_get('shop.access_mode', 'auth', true) === \App\Services\Auth\AccessMode::ANY;
}

/**
 * Checks for the specific rights the shop.
 */
function is_enable(string $action): bool
{
    return (bool)s_get($action);
}

/**
 * Return path to images folder.
 */
function img_path(string $url): string
{
    return public_path("img/$url");
}

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

function humanize_month(string $month): string
{
    return strtr($month, __('content.months'));
}

function short_string(string $string, int $length): string
{
    if (mb_strlen($string) < $length) {
        return $string;
    }

    return mb_substr($string, 0, $length) . '...';
}

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

function username(): ?string
{
    if (!is_auth()) {
        return null;
    }

    return \Sentinel::getUser()->getUsername();
}

function cloak_exists(string $username): bool
{
    return file_exists(config('l-shop.profile.cloaks.path') . '/' . $username . '.png');
}

function get_server_by_id(iterable $servers, int $id): ?ServerInterface
{
    /** @var ServerInterface[] $servers */
    foreach ($servers as $server) {
        if ($server->getId() === $id) {
            return $server;
        }
    }

    return null;
}

function trim_nullable(array $arr): array
{
    return array_filter($arr, function ($val) {
        return $val !== null;
    });
}
