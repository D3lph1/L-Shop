<?php
declare(strict_types = 1);

namespace App\Services\Cart\Storage;

/**
 * Interface Storage
 * Implements the logic of storing items in the shopping cart.
 */
interface Storage
{
    /**
     * Put data in storage.
     *
     * @param int   $serverId Server ID to which item product belongs.
     * @param int   $productId ID of product which belongs to item.
     * @param int $amount The amount of product.
     */
    public function put(int $serverId, int $productId, int $amount): void;

    /**
     * Retrieve amount of item from storage for given server and product.
     *
     * @param int $serverId Server ID which belongs product.
     * @param int $productId
     *
     * @return int
     */
    public function retrieve(int $serverId, int $productId): ?int;

    /**
     * Returns an array of the form `product ID` -> `amount` for passed server.
     *
     * @param int $serverId
     *
     * @return array|null
     */
    public function retrieveServer(int $serverId): ?array;

    /**
     * Remove data from storage by server ID and product ID.
     *
     * @param int $serverId
     * @param int $productId
     *
     * @return bool
     */
    public function remove(int $serverId, int $productId): bool;

    /**
     * Remove all data from given server from storage.
     *
     * @param int $serverId
     *
     * @return bool
     */
    public function removeServer(int $serverId): bool;

    /**
     * Return storage key.
     *
     * @return string
     */
    public function getKey(): string;
}
