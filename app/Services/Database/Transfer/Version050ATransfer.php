<?php
declare(strict_types = 1);

namespace App\Services\Database\Transfer;

use App\Services\Database\Transfer\Queries\Version050a\Query;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

class Version050ATransfer implements Transfer
{
    public const VERSION = '0.5.0a';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var Query
     */
    private $query;

    public function __construct(EntityManagerInterface $em, Query $query)
    {
        $this->em = $em;
        $this->query = $query;
    }

    /**
     * {@inheritdoc}
     */
    public function transfer(string $from, string $to): void
    {
        $this->query->setFrom($from);
        $this->query->setTo($to);

        $this->em->beginTransaction();

        $this->execute($this->query->transferUsersQuery());
        $this->execute($this->query->transferActivationsQuery());
        $this->execute($this->query->transferPersistencesQuery());
        $this->execute($this->query->transferBansQuery());
        $this->execute($this->query->transferServersQuery());
        $this->execute($this->query->transferCategoriesQuery());
        $this->execute($this->query->transferItemsQuery());
        $this->execute($this->query->transferProductsQuery());
        $this->execute($this->query->transferNewsQuery());
        $this->execute($this->query->transferPagesQuery());
        $this->transferPayments();

        $this->em->commit();
    }

    private function execute(string $query, array $params = []): void
    {
        $stmt = $this
            ->em
            ->getConnection()
            ->prepare($query);

        $i = 1;
        foreach ($params as $param) {
            $stmt->bindValue($i, $param);
            $i++;
        }

        $stmt->execute();
    }

    private function transferPayments(): void
    {
        $stmt = $this
            ->em
            ->getConnection()
            ->prepare($this->query->selectPaymentsQuery());
        $stmt->execute();

        while (($payment = $stmt->fetch(\PDO::FETCH_ASSOC)) !== false) {
            $this->execute(
                $this->query->insertPurchaseQuery(),
                [
                    (int)$payment['id'],
                    $payment['user_id'] !== null ? (int)$payment['user_id'] : null,
                    (float)$payment['cost'],
                    $payment['username'],
                    $payment['ip'],
                    $payment['created_at'],
                    $payment['service'],
                    $payment['updated_at']
                ]
            );

            if ($payment['products'] !== null) {
                $productsAndAmount = json_decode($payment['products'], true);
                foreach ($productsAndAmount as $product => $amount) {
                    try {
                        $this->execute($this->query->insertPurchaseItemQuery(), [
                            (int)$product,
                            (int)$payment['id'],
                            (int)$amount
                        ]);
                    } catch (\Exception $e) {
                        $this->execute($this->query->deletePurchaseQuery(), [(int)$payment['id']]);
                    }
                }
            }
        }
    }
}
