<?php
declare(strict_types = 1);

namespace App\Repository\Permission;

use App\Entity\Permission;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrinePermissionRepository implements PermissionRepository
{
    use PaginatesFromParams, ClearsCache;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $er;

    /**
     * @var CachingOptions
     */
    private $cachingOptions;

    public function __construct(EntityManagerInterface $em, EntityRepository $er, CachingOptions $cachingOptions)
    {
        $this->em = $em;
        $this->er = $er;
        $this->cachingOptions = $cachingOptions;
    }

    public function create(Permission $permission): void
    {
        $this->clearResultCache();
        $this->em->persist($permission);
        $this->em->flush();
    }

    public function update(Permission $permission): void
    {
        $this->clearResultCache();
        $this->em->merge($permission);
        $this->em->flush();
    }

    public function remove(Permission $permission): void
    {
        $this->em->remove($permission);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?Permission
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function findByName(string $name): ?Permission
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('permission')
            ->select('permission')
            ->where('permission.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * @inheritDoc
     */
    public function findWhereNameIn(array $names): array
    {
        return $this->er->createQueryBuilder('permission')
            ->where('permission.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this
            ->er
            ->createQueryBuilder('permission')
            ->select('permission')
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage, $page);
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('permission')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findPaginateWithSearch(string $search,int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('permission')
                ->where('permission.name LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('permission')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->where('permission.id LIKE :search')
                ->orWhere('permission.name LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    /**
     * @inheritDoc
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->er->createQueryBuilder($alias, $indexBy);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
