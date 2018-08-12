<?php
declare(strict_types=1);

namespace App\Repository\Purchase;

use App\Entity\Purchase;
use App\Entity\PurchaseItem;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
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

    public function update(Purchase $purchase): void
    {
        $this->em->merge($purchase);
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

    public function findPaginatedByUser(User $user, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('purchase')
                ->where('purchase.user = :user')
                ->setParameter('user', $user)
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findPaginatedWithOrder(int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('purchase')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findPaginatedWithOrderByUser(User $user, int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('purchase')
                ->where('purchase.user = :user')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->setParameter('user', $user)
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function retrieveTotalProfitForYearCompleted(array $exceptVia): array
    {
        return $this->em->createQuery(
            sprintf(
                'SELECT YEAR(p.completedAt) as year, MONTH(p.completedAt) as month, SUM(p.cost) as total
                        FROM %s p
                        WHERE p.completedAt IS NOT NULL
                        AND p.via IS NOT NULL
                        AND p.via NOT IN (:via)
                        GROUP BY year, month
                        ORDER BY year DESC',
                Purchase::class
            )
        )
            ->setParameter('via', $exceptVia)
            ->getResult();
    }

    public function retrieveTotalProfitForMonthCompleted(int $year, int $month, array $exceptVia): array
    {
        return $this->em->createQuery(
            sprintf(
                'SELECT DAY(p.completedAt) as day, SUM(p.cost) as total
                        FROM %s p
                        WHERE p.completedAt IS NOT NULL
                        AND p.via IS NOT NULL
                        AND p.via NOT IN (:via)
                        AND YEAR(p.completedAt) = :year
                        AND MONTH(p.completedAt) = :month
                        AND p.completedAt IS NOT NULL
                        GROUP BY day
                        ORDER BY day',
                Purchase::class,
                PurchaseItem::class
            )
        )
            ->setParameter('via', $exceptVia)
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getResult();
    }

    public function retrieveTotalProfitCompleted(array $exceptVia): float
    {
        return (float)$this->em->createQuery(
            sprintf(
                'SELECT SUM(p.cost) as total
                        FROM %s p
                        WHERE p.completedAt IS NOT NULL
                        AND p.via IS NOT NULL
                        AND p.via NOT IN (:via)',
                Purchase::class,
                PurchaseItem::class
            )
        )
            ->setParameter('via', $exceptVia)
            ->getSingleScalarResult();
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
