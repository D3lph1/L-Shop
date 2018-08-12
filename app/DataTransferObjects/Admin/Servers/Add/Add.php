<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Servers\Add;

class Add
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string[]
     */
    private $categories = [];

    /**
     * @var string|null
     */
    private $ip;

    /**
     * @var int|null
     */
    private $port;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var bool
     */
    private $monitoringEnabled = false;

    /**
     * @var bool
     */
    private $serverEnabled = false;

    /**
     * @var string
     */
    private $distributor;

    public function __construct(string $name, string $distributor)
    {
        $this->name = $name;
        $this->distributor = $distributor;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param string[] $categories
     *
     * @return Add
     */
    public function setCategories(array $categories): Add
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * @param null|string $ip
     *
     * @return Add
     */
    public function setIp(?string $ip): Add
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPort(): ?int
    {
        return $this->port;
    }

    /**
     * @param int|null $port
     *
     * @return Add
     */
    public function setPort(?int $port): Add
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param null|string $password
     *
     * @return Add
     */
    public function setPassword(?string $password): Add
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isMonitoringEnabled(): bool
    {
        return $this->monitoringEnabled;
    }

    /**
     * @param bool $monitoringEnabled
     *
     * @return Add
     */
    public function setMonitoringEnabled(bool $monitoringEnabled): Add
    {
        $this->monitoringEnabled = $monitoringEnabled;

        return $this;
    }

    /**
     * @return bool
     */
    public function isServerEnabled(): bool
    {
        return $this->serverEnabled;
    }

    /**
     * @param bool $serverEnabled
     *
     * @return Add
     */
    public function setServerEnabled(bool $serverEnabled): Add
    {
        $this->serverEnabled = $serverEnabled;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistributor(): string
    {
        return $this->distributor;
    }

    /**
     * @param string $distributor
     *
     * @return Add
     */
    public function setDistributor(string $distributor): Add
    {
        $this->distributor = $distributor;

        return $this;
    }
}
