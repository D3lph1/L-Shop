<?php
declare(strict_types=1);

namespace App\Repository\PurchaseItem;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePurchaseItemRepository implements PurchaseItemRepository
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

    public function retrieveAmountForYearCompleted(): array
    {
        return $this->er->createQueryBuilder('pi')
            ->join('pi.purchase', 'p')
            ->select('YEAR(p.completedAt) as year, MONTH(p.completedAt) as month, COUNT(p.id) as amount')
            ->where('p.completedAt IS NOT NULL')
            ->groupBy('year, month')
            ->orderBy('year', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function retrieveAmountForMonthCompleted(int $year, int $month): array
    {
        return $this->er->createQueryBuilder('pi')
            ->join('pi.purchase', 'p')
            ->select('DAY(p.completedAt) as day, COUNT(p.id) as amount')
            ->where('YEAR(p.completedAt) = :year')
            ->andWhere('MONTH(p.completedAt) = :month')
            ->andWhere('p.completedAt IS NOT NULL')
            ->groupBy('day')
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getQuery()
            ->getResult();
    }

    public function retrieveTopPurchasedProductsCompleted(): array
    {
        return $this->er->createQueryBuilder('pi')
            ->join('pi.purchase', 'purchase')
            ->join('pi.product', 'product')
            ->join('product.item', 'item')
            ->join('product.category', 'c')
            ->join('c.server', 's')
            ->select('item.name as name, product.price as price, c.name as category, s.name as server, COUNT(product.id) as amount')
            ->where('purchase.completedAt IS NOT NULL')
            ->orderBy('amount', 'DESC')
            ->groupBy('product.id')
            ->getQuery()
            ->getResult();
    }

    public function retrievePurchasesAmountCompleted(): int
    {
        return (int)$this->er->createQueryBuilder('pi')
            ->join('pi.purchase', 'p')
            ->select('COUNT(p.id) as amount')
            ->andWhere('p.completedAt IS NOT NULL')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
