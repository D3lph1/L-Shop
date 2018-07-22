<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\ShoppingCartPipeline;

use App\Entity\EnchantmentItem;
use App\Entity\Product;
use App\Entity\PurchaseItem;
use App\Entity\ShoppingCart;
use App\Services\DateTime\DateTimeUtil;
use App\Services\Product\Stack;

class SignatureAndAmountPipe
{
    public function handle(ShoppingCart $entity, \Closure $next)
    {
        $purchaseItem = $entity->getDistribution()->getPurchaseItem();
        $product = $purchaseItem->getProduct();

        switch ($entity->getType()) {
            case ShoppingCart::TYPE_ITEM:
                $entity
                    ->setSignature($this->buildItemSignature($product))
                    ->setAmount($purchaseItem->getAmount());
                break;
            case ShoppingCart::TYPE_PERMGROUP:
                if (Stack::isForever($product)) {
                    $entity->setSignature($product->getItem()->getSignature());
                    $entity->setAmount(1);
                } else {
                    $entity->setSignature($this->buildExpiredPermgroupSignature($purchaseItem));
                    $entity->setAmount(1);
                }
                break;
            case ShoppingCart::TYPE_REGION_OWNER:
            case ShoppingCart::TYPE_REGION_MEMBER:
                $entity->setSignature($product->getItem()->getSignature());
                $entity->setAmount(1);
                break;
            case ShoppingCart::TYPE_CURRENCY:
                $entity->setSignature(null);
                $entity->setAmount($purchaseItem->getAmount());
                break;
        }

        return $next($entity);
    }

    private function buildItemSignature(Product $product): string
    {
        /** @var EnchantmentItem[] $enchantmentItems */
        $enchantmentItems = $product->getItem()->getEnchantmentItems();
        if (count($enchantmentItems) === 0) {
            return $product->getItem()->getSignature();
        }

        $encoded = 0;
        foreach ($enchantmentItems as $enchantmentItem) {
            // Formula: previous * 1000 + enchantment.id * 10 + enchantment.level
            $encoded = $encoded * 1000 + $enchantmentItem->getEnchantment()->getGameId() * 10 + $enchantmentItem->getLevel();
        }
        // Convert number to 32 notation.
        $encoded = base_convert($encoded, 10, 32);

        return "{$product->getItem()->getSignature()}-{$encoded}";
    }

    private function buildExpiredPermgroupSignature(PurchaseItem $purchaseItem): string
    {
        $lifetime = DateTimeUtil::daysToSeconds($purchaseItem->getAmount());

        return "{$purchaseItem->getProduct()->getItem()->getSignature()}?lifetime={$lifetime}";
    }
}
