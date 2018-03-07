<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enchantments_items")
 */
class EnchantmentItem
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="level", type="integer")
     */
    private $level;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Enchantment", inversedBy="enchantmentItems")
     * @ORM\JoinColumn(name="enchantment_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $enchantment;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Item")
     */
    private $item;

    public function __construct(Enchantment $enchantment, int $level)
    {
        $this->enchantment = $enchantment;
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $level
     *
     * @return EnchantmentItem
     */
    public function setLevel(int $level): EnchantmentItem
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    public function getEnchantment(): Enchantment
    {
        return $this->enchantment;
    }

    public function setItem(Item $item): EnchantmentItem
    {
        $this->item = $item;

        return $this;
    }

    public function deleteItem(): EnchantmentItem
    {
        $this->item = null;

        return $this;
    }

    public function getItem(): Item
    {
        return $this->item;
    }
}
