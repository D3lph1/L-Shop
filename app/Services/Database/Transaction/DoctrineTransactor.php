<?php
declare(strict_types = 1);

namespace App\Services\Database\Transaction;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineTransactor implements Transactor
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
     * {@inheritdoc}
     */
    public function begin(): void
    {
        $this->em->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function commit(): void
    {
        $this->em->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function rollback(): void
    {
        $this->em->rollback();
    }
}
