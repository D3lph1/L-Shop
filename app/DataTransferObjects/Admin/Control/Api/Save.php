<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Control\Api;

class Save
{
    /**
     * @var bool
     */
    private $apiEnabled;

    /**
     * @var string
     */
    private $key;

    /**
     * @var string|null
     */
    private $delimiter;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var bool
     */
    private $apiAuthEnabled;

    /**
     * @var bool
     */
    private $apiRegisterEnabled;

    /**
     * @var bool
     */
    private $sashok724sV3LauncherEnabled;

    /**
     * @var string
     */
    private $sashok724sV3LauncherFormat;

    /**
     * @var string[]
     */
    private $sashok724sV3LauncherIPs;

    /**
     * @return bool
     */
    public function isApiEnabled(): bool
    {
        return $this->apiEnabled;
    }

    /**
     * @param bool $apiEnabled
     *
     * @return Save
     */
    public function setApiEnabled(bool $apiEnabled): Save
    {
        $this->apiEnabled = $apiEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return Save
     */
    public function setKey(string $key): Save
    {
        $this->key = $key;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDelimiter(): ?string
    {
        return $this->delimiter;
    }

    /**
     * @param null|string $delimiter
     *
     * @return Save
     */
    public function setDelimiter(?string $delimiter): Save
    {
        $this->delimiter = $delimiter;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     *
     * @return Save
     */
    public function setAlgorithm(string $algorithm): Save
    {
        $this->algorithm = $algorithm;

        return $this;
    }

    /**
     * @return bool
     */
    public function isApiAuthEnabled(): bool
    {
        return $this->apiAuthEnabled;
    }

    /**
     * @param bool $apiAuthEnabled
     *
     * @return Save
     */
    public function setApiAuthEnabled(bool $apiAuthEnabled): Save
    {
        $this->apiAuthEnabled = $apiAuthEnabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isApiRegisterEnabled(): bool
    {
        return $this->apiRegisterEnabled;
    }

    /**
     * @param bool $apiRegisterEnabled
     *
     * @return Save
     */
    public function setApiRegisterEnabled(bool $apiRegisterEnabled): Save
    {
        $this->apiRegisterEnabled = $apiRegisterEnabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSashok724sV3LauncherEnabled(): bool
    {
        return $this->sashok724sV3LauncherEnabled;
    }

    /**
     * @param bool $sashok724sV3LauncherEnabled
     *
     * @return Save
     */
    public function setSashok724sV3LauncherEnabled(bool $sashok724sV3LauncherEnabled): Save
    {
        $this->sashok724sV3LauncherEnabled = $sashok724sV3LauncherEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getSashok724sV3LauncherFormat(): string
    {
        return $this->sashok724sV3LauncherFormat;
    }

    /**
     * @param string $sashok724sV3LauncherFormat
     *
     * @return Save
     */
    public function setSashok724sV3LauncherFormat(string $sashok724sV3LauncherFormat): Save
    {
        $this->sashok724sV3LauncherFormat = $sashok724sV3LauncherFormat;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getSashok724sV3LauncherIPs(): array
    {
        return $this->sashok724sV3LauncherIPs;
    }

    /**
     * @param string[] $sashok724sV3LauncherIPs
     *
     * @return Save
     */
    public function setSashok724sV3LauncherIPs(array $sashok724sV3LauncherIPs): Save
    {
        $this->sashok724sV3LauncherIPs = $sashok724sV3LauncherIPs;

        return $this;
    }
}
