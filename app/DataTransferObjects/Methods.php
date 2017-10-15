<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

/**
 * Class Methods
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects
 */
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
