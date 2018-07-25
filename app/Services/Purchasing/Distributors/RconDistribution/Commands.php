<?php
declare(strict_types=1);

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
     * @var null|string
     */
    private $giveNonEnchantedItemResponse;

    /**
     * @var null|string
     */
    private $giveEnchantedItemResponse;

    /**
     * @var null|string
     */
    private $giveNonExpiredPermgroupResponse;

    /**
     * @var null|string
     */
    private $giveExpiredPermgroupResponse;

    /**
     * @var null|string
     */
    private $giveCurrencyResponse;

    /**
     * @var null|string
     */
    private $addRegionOwnerResponse;

    /**
     * @var null|string
     */
    private $addRegionMemberResponse;

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
     *
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
     *
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
     *
     * @return Commands
     */
    public function setAddRegionMemberCommand(string $addRegionMemberCommand): Commands
    {
        $this->addRegionMemberCommand = $addRegionMemberCommand;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGiveNonEnchantedItemResponse(): ?string
    {
        return $this->giveNonEnchantedItemResponse;
    }

    /**
     * @param null|string $giveNonEnchantedItemResponse
     *
     * @return Commands
     */
    public function setGiveNonEnchantedItemResponse(?string $giveNonEnchantedItemResponse): Commands
    {
        $this->giveNonEnchantedItemResponse = $giveNonEnchantedItemResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGiveEnchantedItemResponse(): ?string
    {
        return $this->giveEnchantedItemResponse;
    }

    /**
     * @param null|string $giveEnchantedItemResponse
     *
     * @return Commands
     */
    public function setGiveEnchantedItemResponse(?string $giveEnchantedItemResponse): Commands
    {
        $this->giveEnchantedItemResponse = $giveEnchantedItemResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGiveNonExpiredPermgroupResponse(): ?string
    {
        return $this->giveNonExpiredPermgroupResponse;
    }

    /**
     * @param null|string $giveNonExpiredPermgroupResponse
     *
     * @return Commands
     */
    public function setGiveNonExpiredPermgroupResponse(?string $giveNonExpiredPermgroupResponse): Commands
    {
        $this->giveNonExpiredPermgroupResponse = $giveNonExpiredPermgroupResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGiveExpiredPermgroupResponse(): ?string
    {
        return $this->giveExpiredPermgroupResponse;
    }

    /**
     * @param null|string $giveExpiredPermgroupResponse
     *
     * @return Commands
     */
    public function setGiveExpiredPermgroupResponse(?string $giveExpiredPermgroupResponse): Commands
    {
        $this->giveExpiredPermgroupResponse = $giveExpiredPermgroupResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getGiveCurrencyResponse(): ?string
    {
        return $this->giveCurrencyResponse;
    }

    /**
     * @param null|string $giveCurrencyResponse
     *
     * @return Commands
     */
    public function setGiveCurrencyResponse(?string $giveCurrencyResponse): Commands
    {
        $this->giveCurrencyResponse = $giveCurrencyResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddRegionOwnerResponse(): ?string
    {
        return $this->addRegionOwnerResponse;
    }

    /**
     * @param null|string $addRegionOwnerResponse
     *
     * @return Commands
     */
    public function setAddRegionOwnerResponse(?string $addRegionOwnerResponse): Commands
    {
        $this->addRegionOwnerResponse = $addRegionOwnerResponse;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddRegionMemberResponse(): ?string
    {
        return $this->addRegionMemberResponse;
    }

    /**
     * @param null|string $addRegionMemberResponse
     *
     * @return Commands
     */
    public function setAddRegionMemberResponse(?string $addRegionMemberResponse): Commands
    {
        $this->addRegionMemberResponse = $addRegionMemberResponse;
        return $this;
    }
}
