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
     * @var string
     */
    private $giveCurrencyCommand;

    /**
     * @var string
     */
    private $addRegionOwnerCommand;

    /**
     * @var string
     */
    private $addRegionMemberCommand;

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

    /**
     * @return string
     */
    public function getGiveCurrencyCommand(): string
    {
        return $this->giveCurrencyCommand;
    }

    /**
     * @param string $giveCurrencyCommand
     * @return Commands
     */
    public function setGiveCurrencyCommand(string $giveCurrencyCommand): Commands
    {
        $this->giveCurrencyCommand = $giveCurrencyCommand;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddRegionOwnerCommand(): string
    {
        return $this->addRegionOwnerCommand;
    }

    /**
     * @param string $addRegionOwnerCommand
     * @return Commands
     */
    public function setAddRegionOwnerCommand(string $addRegionOwnerCommand): Commands
    {
        $this->addRegionOwnerCommand = $addRegionOwnerCommand;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddRegionMemberCommand(): string
    {
        return $this->addRegionMemberCommand;
    }

    /**
     * @param string $addRegionMemberCommand
     * @return Commands
     */
    public function setAddRegionMemberCommand(string $addRegionMemberCommand): Commands
    {
        $this->addRegionMemberCommand = $addRegionMemberCommand;
        return $this;
    }
}
