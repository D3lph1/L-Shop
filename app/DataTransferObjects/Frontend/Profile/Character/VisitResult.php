<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Character;

class VisitResult
{
    /**
     * @var bool
     */
    private $allowSetSkin;

    /**
     * @var bool
     */
    private $allowSetCloak;

    /**
     * @var array
     */
    private $availableSkinImageSizes;

    /**
     * @var array
     */
    private $availableCloakImageSizes;

    /**
     * @var bool
     */
    private $skinDefault;

    /**
     * @var bool
     */
    private $cloakExists;

    /**
     * @return bool
     */
    public function isAllowSetSkin(): bool
    {
        return $this->allowSetSkin;
    }

    public function setAllowSetSkin(bool $value): VisitResult
    {
        $this->allowSetSkin = $value;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowSetCloak(): bool
    {
        return $this->allowSetCloak;
    }

    public function setAllowSetCloak(bool $value): VisitResult
    {
        $this->allowSetCloak = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableSkinImageSizes(): array
    {
        return $this->availableSkinImageSizes;
    }

    public function setAvailableSkinImageSizes(array $sizes): VisitResult
    {
        $this->availableSkinImageSizes = $sizes;

        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableCloakImageSizes(): array
    {
        return $this->availableCloakImageSizes;
    }

    public function setAvailableCloakImageSizes(array $sizes): VisitResult
    {
        $this->availableCloakImageSizes = $sizes;

        return $this;
    }

    /**
     * @param bool $skinDefault
     *
     * @return VisitResult
     */
    public function setSkinDefault(bool $skinDefault): VisitResult
    {
        $this->skinDefault = $skinDefault;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSkinDefault(): bool
    {
        return $this->skinDefault;
    }

    /**
     * @param bool $cloakExists
     *
     * @return VisitResult
     */
    public function setCloakExists(bool $cloakExists): VisitResult
    {
        $this->cloakExists = $cloakExists;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCloakExists(): bool
    {
        return $this->cloakExists;
    }
}
