<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

use App\Entity\User;

class PlayerWithUser extends Player
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user, Group $primaryGroup)
    {
        parent::__construct($primaryGroup);
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
