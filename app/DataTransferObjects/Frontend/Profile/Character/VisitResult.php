<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Profile\Character;

class VisitResult
{
    /**
     * @var array
     */
    private $availableSkinImageSizes;

    /**
     * @var array
     */
    private $availableCloakImageSizes;

    public function __construct(array $availableSkinImageSizes, array $availableCloakImageSizes)
    {
        $this->availableSkinImageSizes = $availableSkinImageSizes;
        $this->availableCloakImageSizes = $availableCloakImageSizes;
    }

    /**
     * @return array
     */
    public function getAvailableSkinImageSizes(): array
    {
        return $this->availableSkinImageSizes;
    }

    /**
     * @return array
     */
    public function getAvailableCloakImageSizes(): array
    {
        return $this->availableCloakImageSizes;
    }
}
