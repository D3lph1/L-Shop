<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;
use App\Exceptions\UnexpectedValueException;
use App\Services\Item\Type;

class Stack
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Formats the quantity of products for the user.
     *
     * @param Product $product
     *
     * @return string
     */
    public static function formatUnits(Product $product): string
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

    public static function formatUnitsForAmount(Product $product, int $amount): string
    {
        if ($product->getItem()->getType() === Type::ITEM) {
            return __('common.item.units.item', ['amount' => $amount]);
        }

        if ($product->getItem()->getType() === Type::PERMGROUP) {
            if ($product->getStack() === 0) {
                return __('common.item.units.forever');
            }

            return __('common.item.units.permgroup', ['duration' => $amount]);
        }

        throw new UnexpectedValueException();
    }

    /**
     * @param Product $product
     *
     * @return bool|null True - if is permgroup selling forever. Null - if it not permgroup.
     */
    public static function isForever(Product $product): ?bool
    {
        if ($product->getItem()->getType() !== Type::PERMGROUP) {
            return null;
        }

        return $product->getStack() === 0;
    }
}
