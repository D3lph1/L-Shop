<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

class AddBan
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var bool
     */
    private $forever;

    /**
     * @var string
     */
    private $mode;

    /**
     * @var string|null
     */
    private $dateTime;

    /**
     * @var int
     */
    private $days;

    /**
     * @var string|null
     */
    private $reason;

    /**
     * @param int $userId
     *
     * @return AddBan
     */
    public function setUserId(int $userId): AddBan
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param bool $forever
     *
     * @return AddBan
     */
    public function setForever(bool $forever): AddBan
    {
        $this->forever = $forever;

        return $this;
    }

    /**
     * @return bool
     */
    public function isForever(): bool
    {
        return $this->forever;
    }

    /**
     * @return string
     */
    public function getMode(): string
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     *
     * @return AddBan
     */
    public function setMode(string $mode): AddBan
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * @param null|string $dateTime
     *
     * @return AddBan
     */
    public function setDateTime(?string $dateTime): AddBan
    {
        $this->dateTime = $dateTime;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDateTime(): ?string
    {
        return $this->dateTime;
    }

    /**
     * @return int
     */
    public function getDays(): int
    {
        return $this->days;
    }

    /**
     * @param int $days
     *
     * @return AddBan
     */
    public function setDays(int $days): AddBan
    {
        $this->days = $days;

        return $this;
    }

    /**
     * @param null|string $reason
     *
     * @return AddBan
     */
    public function setReason(?string $reason): AddBan
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getReason(): ?string
    {
        return $this->reason;
    }
}
