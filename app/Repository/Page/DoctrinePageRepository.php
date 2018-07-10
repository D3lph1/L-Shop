<?php
declare(strict_types = 1);

namespace App\Repository\Page;

use App\Entity\Page;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class DoctrinePageRepository implements PageRepository
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

    public function create(Page $page): void
    {
        $this->clearResultCache();
        $this->em->persist($page);
        $this->em->flush();
    }

    public function update(Page $page): void
    {
        $this->clearResultCache();
        $this->em->merge($page);
        $this->em->flush();
    }

    public function find(int $id): ?Page
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function findByUrl(string $url): ?Page
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('page')
            ->select('page')
            ->where('page.url = :url')
            ->setParameter('url', $url)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    public function findPaginated(int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage, $page);
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('page')
                ->orderBy("page.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function findPaginateWithSearch(string $search, int $page, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('page')
                ->where('page.id LIKE :search')
                ->orWhere('page.title LIKE :search')
                ->orWhere('page.url LIKE :search')
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
            $this->createQueryBuilder('page')
                ->orderBy("page.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->where('page.id LIKE :search')
                ->orWhere('page.title LIKE :search')
                ->orWhere('page.url LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            $page,
            false
        );
    }

    public function remove(Page $page): void
    {
        $this->clearResultCache();
        $this->em->remove($page);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('page')
            ->delete()
            ->getQuery()
            ->getResult();
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
