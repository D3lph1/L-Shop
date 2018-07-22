<?php
declare(strict_types = 1);

namespace App\Services\Product;

use App\Entity\Product;
use App\Exceptions\Item\InvalidTypeException;
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
        return self::formatUnitsForAmount($product, $product->getStack());
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
        switch ($product->getItem()->getType()) {
            case Type::ITEM:
                return __('common.item.units.item', ['amount' => $amount]);
            case Type::PERMGROUP:
                if ($product->getStack() === 0) {
                    return __('common.item.units.forever');
                }

                return __('common.item.units.permgroup', ['duration' => $amount]);
            case Type::CURRENCY:
                return __('common.item.units.currency', ['amount' => $amount]);
            case Type::REGION_OWNER:
            case Type::REGION_MEMBER:
                return __('common.item.units.region', ['amount' => $amount]);
            case Type::COMMAND:
                return __('common.item.units.command', ['amount' => $amount]);
            default:
                throw new UnexpectedValueException("Unexpected product type: {$product}");
        }
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
