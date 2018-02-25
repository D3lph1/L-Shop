<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;
use App\Exceptions\UnexpectedValueException;
use App\Services\Item\Type;

class Stack
{
    private function __construct()
    {
    }

    public static function formatUnits(Product $product)
    {
        if ($product->getItem()->getType() === Type::ITEM) {
            return __('common.item.units.item', ['amount' => $product->getStack()]);
        }

        if ($product->getItem()->getType() === Type::PERMGROUP) {
            if ($product->getStack() === 0) {
                return __('common.item.units.forever');
            }

            return __('common.item.units.permgroup', ['duration' => $product->getStack()]);
        }

        throw new UnexpectedValueException();
    }
}
