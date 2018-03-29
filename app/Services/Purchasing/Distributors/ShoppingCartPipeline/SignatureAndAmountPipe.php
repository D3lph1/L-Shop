<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\ShoppingCartPipeline;

use App\Entity\EnchantmentItem;
use App\Entity\Product;
use App\Entity\PurchaseItem;
use App\Entity\ShoppingCart;
use App\Services\Product\Stack;

class SignatureAndAmountPipe
{
    public function handle(ShoppingCart $entity, \Closure $next)
    {
        $purchaseItem = $entity->getDistribution()->getPurchaseItem();
        $product = $purchaseItem->getProduct();
        if ($entity === ShoppingCart::TYPE_ITEM) {
            $entity
                ->setSignature($this->buildItemSignature($product))
                ->setAmount($purchaseItem->getAmount());
        } elseif ($entity === ShoppingCart::TYPE_PERMGROUP) {
            if (Stack::isForever($product)) {
                $entity->setSignature($product->getItem()->getGameId());
            } else {
                $entity->setSignature($this->buildExpiredPermgroupSignature($purchaseItem));
            }
        }

        return $next($entity);
    }

    private function buildItemSignature(Product $product): string
    {
        /** @var EnchantmentItem[] $enchantmentItems */
        $enchantmentItems = $product->getItem()->getEnchantmentItems();
        if (count($enchantmentItems) === 0) {
            return $product->getItem()->getGameId();
        }

        $encoded = 0;
        foreach ($enchantmentItems as $enchantmentItem) {
            // Formula: previous * 1000 + enchantment.id * 10 + enchantment.level
            $encoded = $encoded * 1000 + $enchantmentItem->getEnchantment()->getGameId() * 10 + $enchantmentItem->getLevel();
        }
        // Convert number to 32 notation.
        $encoded = base_convert($encoded, 10, 32);

        return "{$product->getItem()->getGameId()}-{$encoded}";
    }

    private function buildExpiredPermgroupSignature(PurchaseItem $purchaseItem): string
    {
        return "{$purchaseItem->getProduct()->getItem()->getGameId()}?lifetime={$purchaseItem->getAmount()}";
    }
}
