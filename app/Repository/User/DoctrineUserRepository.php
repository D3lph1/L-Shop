<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Entity\User;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineUserRepository implements UserRepository
{
    use PaginatesFromRequest, ClearsCache;

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

    public function create(User $user): void
    {
        $this->clearResultCache();
        $this->em->persist($user);
        $this->em->flush();
    }

    public function update(User $user): void
    {
        $this->clearResultCache();
        $this->em->merge($user);
        $this->em->flush();
    }

    public function remove(User $user): void
    {
        $this->clearResultCache();
        $this->em->remove($user);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('user')
            ->select(['user', 'permissions', 'roles', 'rolePermissions'])
            ->leftJoin('user.permissions', 'permissions')
            ->leftJoin('user.roles', 'roles')
            ->leftJoin('roles.permissions', 'rolePermissions')
            ->where('user.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    public function findByUsername(string $username): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('user')
            ->select('user')
            ->where('user.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    public function findByEmail(string $email): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('user')
            ->select('user')
            ->where('user.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    public function findPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage);
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('u')
                ->orderBy("u.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('u')
                ->where('u.id LIKE :search')
                ->orWhere('u.username LIKE :search')
                ->orWhere('u.email LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginatedWithOrderAndSearch(string $orderBy, bool $descending, string $search, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('u')
                ->orderBy("u.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->where('u.id LIKE :search')
                ->orWhere('u.username LIKE :search')
                ->orWhere('u.email LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findAllAsIterable(): IterableResult
    {
        return $this
            ->er
            ->createQueryBuilder('u')
            ->select()
            ->getQuery()
            ->iterate();
    }

    public function retrieveCreatedForYear(): array
    {
        return $this->createQueryBuilder('u')
            ->select('YEAR(u.createdAt) as year, MONTH(u.createdAt) as month, COUNT(u.id) as amount')
            ->groupBy('year, month')
            ->orderBy('year', 'desc')
            ->getQuery()
            ->getResult();
    }

    public function retrieveCreatedForMonth(int $year, int $month): array
    {
        return $this->createQueryBuilder('u')
            ->select('DAY(u.createdAt) as day, COUNT(u.id) as amount')
            ->where('YEAR(u.createdAt) = :year')
            ->andWhere('MONTH(u.createdAt) = :month')
            ->groupBy('day')
            ->setParameter('year', $year)
            ->setParameter('month', $month)
            ->getQuery()
            ->getResult();
    }

    public function retrieveCreatedAmount(): int
    {
        return (int)$this->createQueryBuilder('u')
            ->select('COUNT(u.id) as amount')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * {@inheritdoc}
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
