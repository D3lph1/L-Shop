<?php
declare(strict_types = 1);

namespace App\Services\Media\Character\Skin;

use App\Entity\User;
use App\Services\Auth\Permissions;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class Accessor
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function allowSet(User $user): bool
    {
        if ($this->allowSetHD($user)) {
            return true;
        }

        if ($user->hasPermission(Permissions::ALLOW_SET_SKINS_IMPORTANT)) {
            return true;
        }

        if (!$this->enabled()) {
            return false;
        }

        return $user->hasPermission(Permissions::ALLOW_SET_SKINS);
    }

    public function allowSetHD(User $user): bool
    {
        if ($user->hasPermission(Permissions::ALLOW_SET_HD_SKINS_IMPORTANT)) {
            return true;
        }

        if (!$this->enabled()) {
            return false;
        }

        if ($user->hasPermission(Permissions::ALLOW_SET_HD_SKINS) &&
            $this->settings->get('system.profile.character.skin.hd.enabled')->getValue(DataType::BOOL)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool Is it possible to set skins at all?
     */
    public function enabled(): bool
    {
        return $this->settings->get('system.profile.character.skin.enabled')->getValue(DataType::BOOL);
    }
}
