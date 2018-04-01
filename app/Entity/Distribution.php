<?php
declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="distributions")
 */
class Distribution
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PurchaseItem")
     */
    private $purchaseItem;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\ShoppingCart")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $shoppingCart;

    public function __construct(PurchaseItem $purchaseItem)
    {
        $this->purchaseItem = $purchaseItem;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPurchaseItem(): PurchaseItem
    {
        return $this->purchaseItem;
    }

    public function getShoppingCart(): ?Distribution
    {
        return $this->shoppingCart;
    }

    public function setShoppingCart(ShoppingCart $shoppingCart): Distribution
    {
        $this->shoppingCart = $shoppingCart;

        return $this;
    }
}
