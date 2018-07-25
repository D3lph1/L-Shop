<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

class ExecutableCommands
{
    /**
     * @var string[]
     */
    private $extraAfterCommands = [];

    /**
     * @var MainCommand[]
     */
    private $mainCommands = [];

    /**
     * @var string[]
     */
    private $extraBeforeCommands = [];

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
     * @return ExecutableCommands
     */
    public function setExtraAfterCommands(array $extraAfterCommands): ExecutableCommands
    {
        $this->extraAfterCommands = $extraAfterCommands;

        return $this;
    }

    /**
     * @return MainCommand[]
     */
    public function getMainCommands(): array
    {
        return $this->mainCommands;
    }

    /**
     * @param MainCommand[] $mainCommands
     *
     * @return ExecutableCommands
     */
    public function setMainCommands(array $mainCommands): ExecutableCommands
    {
        $this->mainCommands = $mainCommands;

        return $this;
    }

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
     * @return ExecutableCommands
     */
    public function setExtraBeforeCommands(array $extraBeforeCommands): ExecutableCommands
    {
        $this->extraBeforeCommands = $extraBeforeCommands;

        return $this;
    }
}
