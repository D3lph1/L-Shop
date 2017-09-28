<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

class Methods
{
    /**
     * @var null|string
     */
    private $robokassa;

    /**
     * @var null|string
     */
    private $interkassa;

    public function __construct(?string $robokassa, ?string $interkassa)
    {
        $this->robokassa = $robokassa;
        $this->interkassa = $interkassa;
    }

    public function getRobokassa(): ?string
    {
        return $this->robokassa;
    }

    public function getInterkassa(): ?string
    {
        return $this->interkassa;
    }
}
