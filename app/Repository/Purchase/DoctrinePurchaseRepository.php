<?php
declare(strict_types = 1);

namespace App\Repository\Purchase;

use App\Entity\Purchase;
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
