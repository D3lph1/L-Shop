<?php
declare(strict_types = 1);

namespace App\Services\Database\Truncater;

use Doctrine\ORM\EntityManagerInterface;

class PostgreSQLTruncater implements Truncater
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
        $connection = $this->em->getConnection();
        $platform   = $connection->getDatabasePlatform();
        $table = $this->em->getClassMetadata($entityClassName)->getTableName();

        $connection->executeUpdate($platform->getTruncateTableSQL($table, true));
    }
}
