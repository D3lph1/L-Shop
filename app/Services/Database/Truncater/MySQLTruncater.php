<?php
declare(strict_types = 1);

namespace App\Services\Database\Truncater;

use Doctrine\ORM\EntityManagerInterface;

class MySQLTruncater implements Truncater
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function truncate(string $entityClassName): void
    {
        $meta = $this->em->getClassMetadata($entityClassName);
        $connection = $this->em->getConnection();
        $dbPlatform = $connection->getDatabasePlatform();
        $connection->query('SET FOREIGN_KEY_CHECKS=0');
        $q = $dbPlatform->getTruncateTableSql($meta->getTableName(), true);
        $connection->executeUpdate($q);
        $connection->query('SET FOREIGN_KEY_CHECKS=1');
    }
}
