<?php
declare(strict_types = 1);

namespace App\Repository\Page;

use App\Entity\Page;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrinePageRepository implements PageRepository
{
    use PaginatesFromRequest;

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

    public function create(Page $page): void
    {
        $this->em->persist($page);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByUrl(string $url): ?Page
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['url' => $url]);
    }

    public function findPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage);
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('p')
                ->orderBy("p.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('p')
                ->where('p.id LIKE :search')
                ->orWhere('p.title LIKE :search')
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
            $this->createQueryBuilder('p')
                ->orderBy("p.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->where('p.id LIKE :search')
                ->orWhere('p.title LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->er->createQueryBuilder($alias, $indexBy);
    }
}
