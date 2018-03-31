<?php
declare(strict_types = 1);

namespace App\Repository\Purchase;

use App\Entity\Purchase;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePurchaseRepository implements PurchaseRepository
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

    public function create(Purchase $purchase): void
    {
        $this->em->persist($purchase);
        $this->em->flush();
    }

    public function find(int $id): ?Purchase
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
