<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions;

class PlayerWithUsername extends Player
{
    /**
     * @var string
     */
    private $username;

    public function __construct(string $username, Group $primaryGroup)
    {
        parent::__construct($primaryGroup);
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
