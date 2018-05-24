<?php
declare(strict_types = 1);

namespace App\Services\Database\Transfer\Queries\Version050a;

/**
 * Class MySQLQuery
 * Stores queries for transfer data from L-Shop version 0.5.0a by MySQL.
 */
class MySQLQuery implements Query
{
    /**
     * @var string
     */
    private $from = 'l_shop.lshop_';

    /**
     * @var string
     */
    private $to = 'lshop.lshop_';

    /**
     * {@inheritdoc}
     */
    public function transferUsersQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}users (
              id,
              username,
              email,
              password,
              balance,
              uuid,
              access_token,
              server_id,
              created_at
            )
            
              SELECT
                id,
                username,
                email,
                password,
                balance,
                uuid,
                accessToken,
                serverID,
                created_at
              FROM {$this->from}users;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferActivationsQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}activations (
              id,
              user_id,
              code,
              completed_at,
              created_at
            )
              SELECT
                id,
                user_id,
                code,
                completed_at,
                created_at
              FROM {$this->from}activations;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferPersistencesQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}persistences (
              id,
              user_id,
              code,
              created_at
            )
              SELECT
                id,
                user_id,
                code,
                created_at
              FROM {$this->from}persistences;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferBansQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}bans (
              id,
              user_id,
              until,
              reason,
              created_at
            )
              SELECT
                id,
                user_id,
                until,
                reason,
                created_at
              FROM {$this->from}bans;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferServersQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}servers (
              id,
              name,
              ip,
              port,
              password,
              distributor,
              enabled,
              monitoring_enabled
            )
              SELECT
                id,
                name,
                ip,
                port,
                password,
                'App\\Services\\Purchasing\\Distributors\\ShoppingCartDistributor',
                enabled,
                monitoring_enabled
              FROM {$this->from}servers;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferCategoriesQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}categories (
              id,
              server_id,
              name
            )
              SELECT
                id,
                server_id,
                name
              FROM {$this->from}categories;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferItemsQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}items (
              id,
              name,
              description,
              type,
              image,
              game_id,
              extra
            )
              SELECT
                id,
                name,
                description,
                type,
                image,
                item,
                extra
              FROM {$this->from}items;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferProductsQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}products (
              id,
              item_id,
              category_id,
              price,
              stack,
              sort_priority,
              hidden
            )
              SELECT
                id,
                item_id,
                category_id,
                price,
                stack,
                sort_priority,
                0
              FROM {$this->from}products;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferNewsQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}news (
              id,
              user_id,
              title,
              content,
              created_at
            )
              SELECT
                id,
                user_id,
                title,
                content,
                created_at
              FROM {$this->from}news;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function transferPagesQuery(): string
    {
        return <<<SQL
            INSERT INTO {$this->to}pages (
              id,
              title,
              content,
              url
            )
              SELECT
                id,
                title,
                content,
                url
              FROM {$this->from}pages;
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function selectPaymentsQuery(): string
    {
        return "SELECT * FROM {$this->from}payments";
    }

    /**
     * {@inheritdoc}
     */
    public function insertPurchaseQuery(): string
    {
        return <<<SQL
          INSERT INTO {$this->to}purchases (
            id,
            user_id,
            cost,
            player,
            ip,
            created_at,
            via,
            completed_at
          )
            VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function insertPurchaseItemQuery(): string
    {
        return <<<SQL
          INSERT INTO {$this->to}purchase_items (
            product_id,
            purchase_id,
            amount
          ) 
            VALUES (?,?,?)
SQL;
    }

    /**
     * {@inheritdoc}
     */
    public function deletePurchaseQuery(): string
    {
        return "DELETE FROM {$this->to}purchases WHERE id = ?";
    }

    /**
     * {@inheritdoc}
     */
    public function setFrom(string $from): MySQLQuery
    {
        $this->from = $from;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTo(string $to): MySQLQuery
    {
        $this->to = $to;

        return $this;
    }
}
