<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents enchanting in the game. The {@see \App\Entity\Item} can be enchanted if
 * {@see \App\Entity\Item::type} = {@see \App\Services\Item\Type::ITEM}.
 *
 * @ORM\Entity
 * @ORM\Table(name="enchantments")
 */
class Enchantment
{
    /**
     * Enchantment identifier.
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * In-game enchantment identifier.
     *
     * @ORM\Column(name="game_id", type="integer", unique=true)
     */
    private $gameId;

    /**
     * The maximum level that this enchantment can have.
     *
     * @ORM\Column(name="max_level", type="smallint")
     */
    private $maxLevel;

    /**
     * Groups enchantments by type. Charms belonging to different groups can not be superimposed
     * on the same thing.
     *
     * <p>If it is null, then the enchantment does not have a group and can be cast along with
     * enchantments from other groups. An example of a enchantment without a group is
     * {@see \App\Services\Item\Enchantment\Enchantments::UNBREAKING}, since it is
     * possible to make absolutely any enchanting target durable.</p>
     *
     * @see \App\Services\Item\Enchantment\Enchantments
     *
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

    /**
     * @return int
     */
    public function getMaxLevel(): int
    {
        return $this->maxLevel;
    }

    /**
     * @return null|string
     */
    public function getGroup(): ?string
    {
        return $this->group;
    }

    /**
     * @param null|string $group
     *
     * @return Enchantment
     */
    public function setGroup(?string $group): Enchantment
    {
        $this->group = $group;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getEnchantmentItems(): Collection
    {
        return $this->enchantmentItems;
    }
}
