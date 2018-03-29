<?php
declare(strict_types = 1);

namespace App\Repository\BalanceTransaction;

use App\Entity\BalanceTransaction;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineBalanceTransactionRepository implements BalanceTransactionRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $er;

    public function __construct(EntityManagerInterface $em, EntityRepository $er)
    {
        $this->em = $em;
        $this->er = $er;
    }

    public function create(BalanceTransaction $transaction): void
    {
        $this->em->persist($transaction);
        $this->em->flush();
    }
}
