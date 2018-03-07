<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enchantments")
 */
class Enchantment
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="game_id", type="integer", unique=true)
     */
    private $gameId;

    /**
     * @ORM\Column(name="max_level", type="smallint")
     */
    private $maxLevel;

    /**
     * @ORM\Column(name="`group`", type="string", length=32, nullable=true)
     */
    private $group;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnchantmentItem", mappedBy="item")
     */
    private $enchantmentItems;

    public function __construct(int $gameId, int $maxLevel = 1, ?string $group = null)
    {
        $this->gameId = $gameId;
        $this->maxLevel = $maxLevel;
        $this->group = $group;
        $this->enchantmentItems = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $gameId
     *
     * @return Enchantment
     */
    public function setGameId(int $gameId): Enchantment
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getGameId(): int
    {
        return $this->gameId;
    }

    /**
     * @param int $maxLevel
     *
     * @return Enchantment
     */
    public function setMaxLevel(int $maxLevel): Enchantment
    {
        $this->maxLevel = $maxLevel;

        return $this;
    }

    public function getMaxLevel(): int
    {
        return $this->maxLevel;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): Enchantment
    {
        $this->group = $group;

        return $this;
    }

    public function getEnchantmentItems(): Collection
    {
        return $this->enchantmentItems;
    }
}
