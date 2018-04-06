<?php
declare(strict_types = 1);

namespace App\Repository\Distribution;

use App\Entity\Distribution;
use App\Entity\Server;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrineDistributionRepository implements DistributionRepository
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

    public function create(Distribution $distribution): void
    {
        $this->em->persist($distribution);
        $this->em->flush();
    }

    public function update(Distribution $distribution): void
    {
        $this->em->merge($distribution);
        $this->em->flush();
    }

    public function findByUserPaginated(User $user, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('distribution')
                ->join('distribution.purchaseItem', 'purchaseItem')
                ->join('purchaseItem.purchase', 'purchase')
                ->where('purchase.user = :user')
                ->setParameter('user', $user)
                ->getQuery(),
            $perPage,
            $page
        );
    }

    public function findByUserPaginatedWithOrder(User $user, int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('distribution')
                ->join('distribution.purchaseItem', 'purchaseItem')
                ->join('purchaseItem.purchase', 'purchase')
                ->join('purchaseItem.product', 'product')
                ->join('product.item', 'item')
                ->join('product.category', 'category')
                ->join('category.server', 'server')
                ->where('purchase.user = :user')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->setParameter('user', $user)
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findByUserAndServerPaginated(User $user, Server $server, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('distribution')
                ->join('distribution.purchaseItem', 'purchaseItem')
                ->join('purchaseItem.purchase', 'purchase')
                ->join('purchaseItem.product', 'product')
                ->join('product.category', 'category')
                ->join('category.server', 'server')
                ->where('purchase.user = :user')
                ->andWhere('category.server = :server')
                ->setParameter('user', $user)
                ->setParameter('server', $server)
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findByUserAndServerPaginatedWithOrder(User $user, Server $server, int $page, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('distribution')
                ->join('distribution.purchaseItem', 'purchaseItem')
                ->join('purchaseItem.purchase', 'purchase')
                ->join('purchaseItem.product', 'product')
                ->join('product.item', 'item')
                ->join('product.category', 'category')
                ->join('category.server', 'server')
                ->where('purchase.user = :user')
                ->andWhere('category.server = :server')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->setParameter('user', $user)
                ->setParameter('server', $server)
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('d')
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
