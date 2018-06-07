<?php
declare(strict_types = 1);

namespace App\DataTransferObjects\Admin\Users;

use App\Entity\User as Entity;

class User implements \JsonSerializable
{
    /**
     * @var Entity
     */
    private $user;

    /**
     * @var bool
     */
    private $isActivated;

    /**
     * @var bool
     */
    private $isBanned;

    public function __construct(Entity $user, bool $isActivated, bool $isBanned)
    {
        $this->user = $user;
        $this->isActivated = $isActivated;
        $this->isBanned = $isBanned;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId(),
            'username' => $this->user->getUsername(),
            'email' => $this->user->getEmail(),
            'balance' => $this->user->getBalance(),
            'isActivated' => $this->isActivated,
            'isBanned' => $this->isBanned
        ];
    }
}
