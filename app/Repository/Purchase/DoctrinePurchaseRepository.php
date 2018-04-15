<?php
declare(strict_types=1);

namespace App\Repository\Purchase;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrinePurchaseRepository implements PurchaseRepository
{
    use PaginatesFromParams;

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

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage, $page);
    }

    public function findPaginatedWithOrder(int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('i')
                ->orderBy("i.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function retrieveTotalProfitForYearCompleted(): array
    {
        return $this->em->createQuery(
            sprintf(
                'SELECT YEAR(p.completedAt) as year, MONTH(p.completedAt) as month, SUM(p.cost) as total
                        FROM %s p
                        WHERE ((SELECT COUNT(pi.id) FROM %s pi WHERE pi.purchase = p.id) = 0
                          OR p.player IS NOT NULL
                        )
                        AND p.completedAt IS NOT NULL
                        GROUP BY year, month
                        ORDER BY year DESC',
                Purchase::class,
                PurchaseItem::class
            )
        )->getResult();
    }

    public function retrieveTotalProfitForMonthCompleted(int $year, int $month): array
    {
        return $this->em->createQuery(
            sprintf(
                'SELECT DAY(p.completedAt) as day, SUM(p.cost) as total
                        FROM %s p
                        WHERE ((SELECT COUNT(pi.id) FROM %s pi WHERE pi.purchase = p.id) = 0
                          OR p.player IS NOT NULL
                        )
                        AND YEAR(p.completedAt) = :year
                        AND MONTH(p.completedAt) = :month
                        AND p.completedAt IS NOT NULL
                        GROUP BY day
                        ORDER BY day',
                Purchase::class,
                PurchaseItem::class
            )
        )
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getResult();
    }

    public function retrieveTotalProfitCompleted(): float
    {
        return (float)$this->em->createQuery(
            sprintf(
                'SELECT SUM(p.cost) as total
                        FROM %s p
                        WHERE ((SELECT COUNT(pi.id) FROM %s pi WHERE pi.purchase = p.id) = 0
                          OR p.player IS NOT NULL
                        )
                        AND p.completedAt IS NOT NULL',
                Purchase::class,
                PurchaseItem::class
            )
        )->getSingleScalarResult();
    }

    public function retrieveFillBalanceAmountCompleted(): int
    {
        return (int)$this->em->createQuery(
                sprintf(
                    'SELECT COUNT(purchase.id) amount
                            FROM %s purchase
                            WHERE (SELECT COUNT(pi.id) FROM %s pi WHERE pi.purchase = purchase.id) = 0
                            AND purchase.completedAt IS NOT NULL',
                    Purchase::class,
                    PurchaseItem::class
                )
            )
            ->getSingleScalarResult();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->er->createQueryBuilder($alias, $indexBy);
    }
}
