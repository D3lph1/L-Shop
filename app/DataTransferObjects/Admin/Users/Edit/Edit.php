<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users\Edit;

class Edit
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
     * @var string|null
     */
    private $password;

    /**
     * @var string[]
     */
    private $roles;

    /**
     * @var string[]
     */
    private $permissions;

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     *
     * @return Edit
     */
    public function setUserId(int $userId): Edit
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     *
     * @return Edit
     */
    public function setUsername(string $username): Edit
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Edit
     */
    public function setEmail(string $email): Edit
    {
        $this->email = $email;

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
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     *
     * @return Edit
     */
    public function setRoles(array $roles): Edit
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param string[] $permissions
     *
     * @return Edit
     */
    public function setPermissions(array $permissions): Edit
    {
        $this->permissions = $permissions;

        return $this;
    }
}
