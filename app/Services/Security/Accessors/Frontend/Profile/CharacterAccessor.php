<?php
declare(strict_types = 1);

namespace App\Services\Security\Accessors\Frontend\Profile;

use App\Services\Auth\Auth;
use App\Services\Media\Character\Cloak\Accessor as CloakAccessor;
use App\Services\Media\Character\Skin\Accessor as SkinAccessor;
use App\Services\Security\Accessors\Accessor;

class CharacterAccessor implements Accessor
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

    public function __construct(Auth $auth, SkinAccessor $skinAccessor, CloakAccessor $cloakAccessor)
    {
        $this->auth = $auth;
        $this->skinAccessor = $skinAccessor;
        $this->cloakAccessor = $cloakAccessor;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(): bool
    {
        return $this->auth->check() &&
            (
                $this->skinAccessor->allowSet($this->auth->getUser()) ||
                $this->cloakAccessor->allowSet($this->auth->getUser())
            );
    }
}
