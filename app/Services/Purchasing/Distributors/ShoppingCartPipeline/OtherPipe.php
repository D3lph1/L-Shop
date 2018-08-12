<?php
declare(strict_types = 1);

namespace App\Services\Purchasing\Distributors\ShoppingCartPipeline;

use App\Entity\ShoppingCart;

class OtherPipe
{
    public function handle(ShoppingCart $entity, \Closure $next)
    {
        $product = $entity->getDistribution()->getPurchaseItem()->getProduct();
        $entity->setServer($product->getCategory()->getServer());
        $entity->setExtra($product->getItem()->getExtra());

        return $next($entity);
    }
}
