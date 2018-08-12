<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\ShoppingCartPipeline;

use App\Entity\ShoppingCart;
use App\Exceptions\NotImplementedException;
use App\Services\Item\Type;

class TypePipe
{
    public function handle(ShoppingCart $entity, \Closure $next)
    {
        $product = $entity->getDistribution()->getPurchaseItem()->getProduct();
        switch ($product->getItem()->getType()) {
            case Type::ITEM:
                $entity->setType(ShoppingCart::TYPE_ITEM);
                break;
            case Type::PERMGROUP:
                $entity->setType(ShoppingCart::TYPE_PERMGROUP);
                break;
            case Type::CURRENCY:
                $entity->setType(ShoppingCart::TYPE_CURRENCY);
                break;
            case Type::REGION_OWNER:
                $entity->setType(ShoppingCart::TYPE_REGION_OWNER);
                break;
            case Type::REGION_MEMBER:
                $entity->setType(ShoppingCart::TYPE_REGION_MEMBER);
                break;
            default:
                throw new NotImplementedException(
                    "Feature to handle this item type {$product->getItem()} not implemented"
                );
        }

        return $next($entity);
    }
}
