<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;
use App\Exceptions\Item\InvalidTypeException;
use App\Exceptions\LogicException;
use App\Exceptions\UnexpectedValueException;
use App\Services\Item\Type;

/**
 * Class Stack
 * Encapsulates the logic of work with the stack of products.
 */
class Stack
{
    /**
     * Private constructor because this class contains only static methods.
     */
    private function __construct()
    {
    }

    /**
     * Formats the quantity of products in user-friendly format.
     *
     * @param Product $product
     *
     * @return string Formatted units.
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

    /**
     * Formats the specified quantity of products in user-friendly format.
     *
     * @param Product $product
     * @param int     $amount
     *
     * @return string Formatted units.
     */
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
     * Checks whether the permission is sold forever.
     *
     * @param Product $product
     *
     * @return bool True - if is permgroup selling forever.
     * @throws InvalidTypeException If an item with a type not of {@see Type::PERMGROUP} belongs
     *                              to the received product
     */
    public static function isForever(Product $product): bool
    {
        if ($product->getItem()->getType() !== Type::PERMGROUP) {
            throw new InvalidTypeException(Type::PERMGROUP, $product->getItem()->getType());
        }

        return $product->getStack() === 0;
    }
}
