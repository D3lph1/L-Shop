<?php

namespace App\DataTransferObjects\Admin\Servers\Edit;

class Edit
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var EditedCategory[]
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

    public function __construct(int $id, string $name, string $distributor)
    {
        $this->id = $id;
        $this->name = $name;
        $this->distributor = $distributor;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return EditedCategory[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    /**
     * @param EditedCategory[] $categories
     *
     * @return Edit
     */
    public function setCategories(array $categories): Edit
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
     * @return Edit
     */
    public function setIp(?string $ip): Edit
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
     * @return Edit
     */
    public function setPort(?int $port): Edit
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
     * @return Edit
     */
    public function setPassword(?string $password): Edit
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
     * @return Edit
     */
    public function setMonitoringEnabled(bool $monitoringEnabled): Edit
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
     * @return Edit
     */
    public function setServerEnabled(bool $serverEnabled): Edit
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
     * @return Edit
     */
    public function setDistributor(string $distributor): Edit
    {
        $this->distributor = $distributor;

        return $this;
    }
}
