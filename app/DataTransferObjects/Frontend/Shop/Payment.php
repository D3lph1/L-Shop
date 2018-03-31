<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Frontend\Shop;

class Payment
{
    /**
     * @var string
     */
    private $robokassaUrl;

    /**
     * @var string
     */
    private $interkassaUrl;

    /**
     * @param string $robokassaUrl
     *
     * @return Payment
     */
    public function setRobokassaUrl(string $robokassaUrl): Payment
    {
        $this->robokassaUrl = $robokassaUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getRobokassaUrl(): ?string
    {
        return $this->robokassaUrl;
    }

    /**
     * @param string $interkassaUrl
     *
     * @return Payment
     */
    public function setInterkassaUrl(string $interkassaUrl): Payment
    {
        $this->interkassaUrl = $interkassaUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getInterkassaUrl(): ?string
    {
        return $this->interkassaUrl;
    }
}
