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
        $type = $product->getItem()->getType();
        if ($type === Type::ITEM) {
            $entity->setType(ShoppingCart::TYPE_ITEM);
        } elseif ($type === Type::PERMGROUP) {
            $entity->setType(ShoppingCart::TYPE_PERMGROUP);
        } else {
            throw new NotImplementedException(
                "Feature to handle this product type {$product} not implemented"
            );
        }

        return $next($entity);
    }
}
