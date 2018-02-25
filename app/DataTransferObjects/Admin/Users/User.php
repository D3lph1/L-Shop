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

    public function __construct(Entity $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->user->getId(),
            'username' => $this->user->getUsername(),
            'email' => $this->user->getEmail()
        ];
    }
}
