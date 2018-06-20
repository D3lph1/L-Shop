<?php
declare(strict_types = 1);

namespace App\Services\Auth;

class ThrottlingOptions
{
    /**
     * @var int
     */
    private $globalAttempts;

    /**
     * @var int
     */
    private $globalCooldown;

    /**
     * @var int
     */
    private $ipAttempts;

    /**
     * @var int
     */
    private $ipCooldown;

    /**
     * @var int
     */
    private $userAttempts;

    /**
     * @var int
     */
    private $userCooldown;

    /**
     * @return int
     */
    public function getGlobalAttempts(): int
    {
        return $this->globalAttempts;
    }

    /**
     * @param int $globalAttempts
     *
     * @return ThrottlingOptions
     */
    public function setGlobalAttempts(int $globalAttempts): ThrottlingOptions
    {
        $this->globalAttempts = $globalAttempts;

        return $this;
    }

    /**
     * @return int
     */
    public function getGlobalCooldown(): int
    {
        return $this->globalCooldown;
    }

    /**
     * @param int $globalCooldown
     *
     * @return ThrottlingOptions
     */
    public function setGlobalCooldown(int $globalCooldown): ThrottlingOptions
    {
        $this->globalCooldown = $globalCooldown;

        return $this;
    }

    /**
     * @return int
     */
    public function getIpAttempts(): int
    {
        return $this->ipAttempts;
    }

    /**
     * @param int $ipAttempts
     *
     * @return ThrottlingOptions
     */
    public function setIpAttempts(int $ipAttempts): ThrottlingOptions
    {
        $this->ipAttempts = $ipAttempts;

        return $this;
    }

    /**
     * @return int
     */
    public function getIpCooldown(): int
    {
        return $this->ipCooldown;
    }

    /**
     * @param int $ipCooldown
     *
     * @return ThrottlingOptions
     */
    public function setIpCooldown(int $ipCooldown): ThrottlingOptions
    {
        $this->ipCooldown = $ipCooldown;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserAttempts(): int
    {
        return $this->userAttempts;
    }

    /**
     * @param int $userAttempts
     *
     * @return ThrottlingOptions
     */
    public function setUserAttempts(int $userAttempts): ThrottlingOptions
    {
        $this->userAttempts = $userAttempts;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserCooldown(): int
    {
        return $this->userCooldown;
    }

    /**
     * @param int $userCooldown
     *
     * @return ThrottlingOptions
     */
    public function setUserCooldown(int $userCooldown): ThrottlingOptions
    {
        $this->userCooldown = $userCooldown;

        return $this;
    }
}
