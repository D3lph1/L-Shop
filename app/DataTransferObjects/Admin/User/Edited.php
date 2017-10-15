<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\User;

/**
 * Class Edited
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\DataTransferObjects\Admin\User
 */
class Edited
{
    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var float
     */
    private $balance;

    /**
     * @var bool
     */
    private $isAdmin;

    public function setId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function setAdmin(bool $isAdmin): self
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getId(): int
    {
        return $this->userId;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }
}
