<?php
declare(strict_types = 1);

namespace App;

/**
 * Generates a line for specifying an intermediary, which requires the user to have a given permission.
 * <p>For example you may use it for register middleware in controller constructor:</p>
 * <code>
 *  $this->middleware(permission_middleware('my_permission'));
 * </code>
 * <p>Or:</p>
 * <code>
 *  $this->middleware(permission_middleware(\App\Services\Auth\Permissions::ALLOW_SET_HD_SKINS));
 * </code>
 *
 * @param string $permission
 *
 * @return string
 */
function permission_middleware(string $permission): string
{
    return "permission:{$permission}";
}

/**
 * Generates a string to specify the intermediary that is used to indicate the type of access to any page.
 * <p>For example you may use it for register middleware in controller constructor:</p>
 * <code>
 *  $this->middleware(auth_middleware(\App\Services\Auth\AccessMode::GUEST));
 * </code>
 *
 * @param string $mode
 *
 * @return string
 */
function auth_middleware(string $mode): string
{
    return "auth:{$mode}";
}

/**
 * Generates a string to specify the intermediary that is used to resolve access to page by accessor class.
 * <p>For example you may use it for register middleware in controller constructor:</p>
 * <code>
 *  $this->middleware(accessor_middleware(\App\Services\Security\Accessors\MyAccessor::class));
 * </code>
 *
 * @see \App\Services\Security\Accessors\Accessor
 *
 * @param string $accessorClass
 *
 * @return string
 */
function accessor_middleware(string $accessorClass): string
{
    return "accessor:{$accessorClass}";
}

/**
 * Generates a string to specify the intermediary that is used to signature validation parameters.
 * <p>For example you may use it for register middleware in controller constructor:</p>
 * <code>
 *  $this->middleware(signed_middleware(['first', 'second]));
 * </code>
 *
 * @param array $parameters
 *
 * @return string
 */
function signed_middleware(array $parameters = []): string
{
    return 'signed' . (count($parameters) !== 0 ? ':' . implode(',', $parameters) : '');
}
