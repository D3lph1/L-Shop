<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\RconDistribution;

class Commands
{
    /**
     * @var string
     */
    private $giveNonEnchantedItemCommand;

    /**
     * @var string
     */
    private $giveEnchantedItemCommand;

    /**
     * @var string
     */
    private $giveNonExpiredPermgroupCommand;

    /**
     * @var string
     */
    private $giveExpiredPermgroupCommand;

    /**
     * @return string
     */
    public function getGiveNonEnchantedItemCommand(): string
    {
        return $this->giveNonEnchantedItemCommand;
    }

    /**
     * @param string $giveNonEnchantedItemCommand
     *
     * @return Commands
     */
    public function setGiveNonEnchantedItemCommand(string $giveNonEnchantedItemCommand): Commands
    {
        $this->giveNonEnchantedItemCommand = $giveNonEnchantedItemCommand;

        return $this;
    }

    /**
     * @return string
     */
    public function getGiveEnchantedItemCommand(): string
    {
        return $this->giveEnchantedItemCommand;
    }

    /**
     * @param string $giveEnchantedItemCommand
     *
     * @return Commands
     */
    public function setGiveEnchantedItemCommand(string $giveEnchantedItemCommand): Commands
    {
        $this->giveEnchantedItemCommand = $giveEnchantedItemCommand;

        return $this;
    }

    /**
     * @return string
     */
    public function getGiveNonExpiredPermgroupCommand(): string
    {
        return $this->giveNonExpiredPermgroupCommand;
    }

    /**
     * @param string $giveNonExpiredPermgroupCommand
     *
     * @return Commands
     */
    public function setGiveNonExpiredPermgroupCommand(string $giveNonExpiredPermgroupCommand): Commands
    {
        $this->giveNonExpiredPermgroupCommand = $giveNonExpiredPermgroupCommand;

        return $this;
    }

    /**
     * @return string
     */
    public function getGiveExpiredPermgroupCommand(): string
    {
        return $this->giveExpiredPermgroupCommand;
    }

    /**
     * @param string $giveExpiredPermgroupCommand
     *
     * @return Commands
     */
    public function setGiveExpiredPermgroupCommand(string $giveExpiredPermgroupCommand): Commands
    {
        $this->giveExpiredPermgroupCommand = $giveExpiredPermgroupCommand;

        return $this;
    }
}
