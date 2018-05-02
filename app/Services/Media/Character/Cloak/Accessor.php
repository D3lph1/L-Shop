<?php
declare(strict_types=1);

namespace App\Services\Media\Character\Cloak;

use App\Entity\User;
use App\Services\Auth\Permissions;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

/**
 * Class Accessor
 * This class is used to determine if the user has the right to set cloaks / HD cloaks.
 */
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

    /**
     * Checks if the given user has the right to set clocks.
     *
     * @param User $user
     *
     * @return bool True - the user has the right. false - does not have.
     */
    public function allowSet(User $user): bool
    {
        if ($this->allowSetHD($user)) {
            return true;
        }

        if ($user->hasPermission(Permissions::ALLOW_SET_CLOAKS_IMPORTANT)) {
            return true;
        }

        if (!$this->enabled()) {
            return false;
        }

        return $user->hasPermission(Permissions::ALLOW_SET_CLOAKS);
    }

    /**
     * Checks if the given user has the right to set HD cloaks.
     *
     * @param User $user
     *
     * @return bool True - the user has the right. false - does not have.
     */
    public function allowSetHD(User $user): bool
    {
        if ($user->hasPermission(Permissions::ALLOW_SET_HD_CLOAKS_IMPORTANT)) {
            return true;
        }

        if (!$this->enabled()) {
            return false;
        }

        if ($user->hasPermission(Permissions::ALLOW_SET_HD_CLOAKS) &&
            $this->settings->get('system.profile.character.skin.hd.enabled')->getValue(DataType::BOOL)) {
            return true;
        }

        return false;
    }

    /**
     * @return bool Is it possible to set cloaks at all?
     */
    private function enabled(): bool
    {
        return $this->settings->get('system.profile.character.cloak.enabled')->getValue(DataType::BOOL);
    }
}
