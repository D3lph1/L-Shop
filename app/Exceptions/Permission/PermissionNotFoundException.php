<?php
declare(strict_types = 1);

namespace App\Exceptions\Permission;

use App\Exceptions\DomainException;

class PermissionNotFoundException extends DomainException
{
    /**
     * @var mixed|null
     */
    private $cause;

    public function __construct(string $message = "", $cause = null)
    {
        parent::__construct($message);
        $this->cause = $cause;
    }

    public static function byId(int $id): PermissionNotFoundException
    {
        return new PermissionNotFoundException("Permission with id \"{id}\" not found", $id);
    }

    public static function byName(string $name): PermissionNotFoundException
    {
        return new PermissionNotFoundException("Permission with name \"{$name}\" not found", $name);
    }

    /**
     * @return mixed|null
     */
    public function getCause()
    {
        return $this->cause;
    }
}
