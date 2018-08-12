<?php
declare(strict_types = 1);

namespace App\Services\Database\Transfer\Queries\Version050a;

/**
 * Interface Query
 * Stores queries for transfer data from L-Shop version 0.5.0a.
 */
interface Query
{
    /**
     * Returns a query to transfer users.
     *
     * @see \App\Entity\User
     *
     * @return string
     */
    public function transferUsersQuery(): string;

    /**
     * Returns a query to transfer user account activations.
     *
     * @see \App\Entity\Activation
     *
     * @return string
     */
    public function transferActivationsQuery(): string;

    /**
     * Returns a query to transfer user persistence sessions.
     *
     * @see \App\Entity\Persistence
     *
     * @return string
     */
    public function transferPersistencesQuery(): string;

    /**
     * Returns a query to transfer user bans.
     *
     * @see \App\Entity\Ban
     *
     * @return string
     */
    public function transferBansQuery(): string;

    /**
     * Returns a query to transfer servers.
     *
     * @see \App\Entity\Server
     *
     * @return string
     */
    public function transferServersQuery(): string;

    /**
     * Returns a query to transfer user categories.
     *
     * @see \App\Entity\Category
     *
     * @return string
     */
    public function transferCategoriesQuery(): string;

    /**
     * Returns a query to transfer items.
     *
     * @see \App\Entity\Item
     *
     * @return string
     */
    public function transferItemsQuery(): string;

    /**
     * Returns a query to transfer products.
     *
     * @see \App\Entity\Product
     *
     * @return string
     */
    public function transferProductsQuery(): string;

    /**
     * Returns a query to transfer news.
     *
     * @see \App\Entity\News
     *
     * @return string
     */
    public function transferNewsQuery(): string;

    /**
     * Returns a query to transfer pages.
     *
     * @see \App\Entity\Page
     *
     * @return string
     */
    public function transferPagesQuery(): string;

    /**
     * Returns a query to select payments.
     *
     * @see \App\Entity\Purchase
     * @see \App\Entity\PurchaseItem
     *
     * @return string
     */
    public function selectPaymentsQuery(): string;

    /**
     * Returns a query to insert purchase.
     *
     * @see \App\Entity\Purchase
     *
     * @return string
     */
    public function insertPurchaseQuery(): string;

    /**
     * Returns a query to insert purchase.
     *
     * @see \App\Entity\PurchaseItem
     *
     * @return string
     */
    public function insertPurchaseItemQuery(): string;

    /**
     * Returns a query to delete purchase.
     *
     * @see \App\Entity\Purchase
     *
     * @return string
     */
    public function deletePurchaseQuery(): string;

    /**
     * Sets the (database name)/(table prefix) from which the import will be made.
     *
     * @param string $prefixFrom
     *
     * @return MySQLQuery
     */
    public function setFrom(string $prefixFrom): MySQLQuery;

    /**
     * Sets the (database name)/(table prefix) of the tables to be exported.
     *
     * @param string $prefixTo
     *
     * @return MySQLQuery
     */
    public function setTo(string $prefixTo): MySQLQuery;
}
