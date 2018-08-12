<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lp_tracks")
 */
class Track
{
    /**
     * @ORM\Id
     * @ORM\Column(name="name", type="string", length=36)
     */
    private $name;

    /**
     * @ORM\Column(name="groups", type="text")
     */
    private $groups;

    public function __construct(string $name, string $groups)
    {
        $this->name = $name;
        $this->groups = $groups;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGroups(): string
    {
        return $this->groups;
    }
}
