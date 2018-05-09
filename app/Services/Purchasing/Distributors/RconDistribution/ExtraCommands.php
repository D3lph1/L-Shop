<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

class ExtraCommands
{
    /**
     * @var string[]
     */
    private $extraBeforeCommands = [];

    /**
     * @var string[]
     */
    private $extraAfterCommands = [];

    /**
     * @return string[]
     */
    public function getExtraBeforeCommands(): array
    {
        return $this->extraBeforeCommands;
    }

    /**
     * @param string[] $extraBeforeCommands
     *
     * @return ExtraCommands
     */
    public function setExtraBeforeCommands(array $extraBeforeCommands): ExtraCommands
    {
        $this->extraBeforeCommands = $extraBeforeCommands;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getExtraAfterCommands(): array
    {
        return $this->extraAfterCommands;
    }

    /**
     * @param string[] $extraAfterCommands
     *
     * @return ExtraCommands
     */
    public function setExtraAfterCommands(array $extraAfterCommands): ExtraCommands
    {
        $this->extraAfterCommands = $extraAfterCommands;

        return $this;
    }
}
