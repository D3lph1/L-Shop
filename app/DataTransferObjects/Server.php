<?php
declare(strict_types = 1);

namespace App\DataTransferObjects;

use App\Exceptions\UnexpectedValueException;

/**
 * Class Server
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function isEnabled(): bool
    {
        return (bool)$this->enabled;
    }

    /**
     * @param Category[] $categories
     *
     * @return $this
     */
    public function setCategories(array $categories): self
    {
        foreach ($categories as $category) {
            if (!($category instanceof Category)) {
                throw new UnexpectedValueException(
                    'Argument $categories must contains only App\DataTransferObjects\Category elements'
                );
            }
        }
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function setIp(?string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setPort(?int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function getPort(): ?int
    {
        return $this->port;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setMonitoringEnabled(bool $value): self
    {
        $this->monitoringEnabled = $value;

        return $this;
    }

    public function isMonitoringEnabled(): bool
    {
        return $this->monitoringEnabled;
    }
}
