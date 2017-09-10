<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\DataTransferObjects\Admin
 */
class Server
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
     * @var bool
     */
    private $enabled;

    /**
     * @var Category[]
     */
    private $categories;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var int
     */
    private $port;

    /**
     * @var string
     */
    private $password;

    /**
     * @var bool
     */
    private $monitoringEnabled;

    public function __construct(
        string $name,
        bool $enabled,
        array $categories,
        string $ip,
        int $port,
        string $password,
        bool $monitoringEnabled)
    {
        $this->name = $name;
        $this->enabled = $enabled;
        $this->categories = $categories;
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
        $this->monitoringEnabled = $monitoringEnabled;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isMonitoringEnabled(): bool
    {
        return $this->monitoringEnabled;
    }
}
