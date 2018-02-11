<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Profile\Character;

use App\DataTransferObjects\Frontend\Profile\Character\VisitResult;
use App\Services\Auth\Auth;
use App\Services\Media\Character\Cloak\Accessor as CloakAccessor;
use App\Services\Media\Character\Skin\Accessor as SkinAccessor;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;

class VisitHandler
{
    /**
     * @var Auth
     */
    private $auth;
    /**
     * @var SkinAccessor
     */
    private $skinAccessor;
    /**
     * @var CloakAccessor
     */
    private $cloakAccessor;
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Auth $auth, SkinAccessor $skinAccessor, CloakAccessor $cloakAccessor, Settings $settings)
    {
        $this->auth = $auth;
        $this->skinAccessor = $skinAccessor;
        $this->cloakAccessor = $cloakAccessor;
        $this->settings = $settings;
    }

    public function handle()
    {
        if ($this->skinAccessor->allowSetHD($this->auth->getUser())) {
            $availableSkinImageSizes = $this->settings->get('system.profile.character.skin.hd.list')->getValue(DataType::JSON);
        } elseif ($this->skinAccessor->allowSet($this->auth->getUser())) {
            $availableSkinImageSizes = $this->settings->get('system.profile.character.skin.list')->getValue(DataType::JSON);
        } else {
            $availableSkinImageSizes = null;
        }

        if ($this->cloakAccessor->allowSetHD($this->auth->getUser())) {
            $availableCloakImageSizes = $this->settings->get('system.profile.character.cloak.hd.list')->getValue(DataType::JSON);
        } elseif ($this->cloakAccessor->allowSet($this->auth->getUser())) {
            $availableCloakImageSizes = $this->settings->get('system.profile.character.cloak.list')->getValue(DataType::JSON);
        } else {
            $availableCloakImageSizes = null;
        }

        return new VisitResult($availableSkinImageSizes, $availableCloakImageSizes);
    }
}
