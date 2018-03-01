<?php
declare(strict_types = 1);

namespace App\Repository\Item;

use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineItemRepository implements ItemRepository
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

    public function create(Item $item): void
    {
        $this->em->persist($item);
        $this->em->flush();
    }

    public function update(Item $item): void
    {
        $this->em->merge($item);
        $this->em->flush();
    }

    public function find(int $id): ?Item
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function findAll(): array
    {
        return $this->er->findAll();
    }

    public function findPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage);
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('i')
                ->orderBy("i.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('i')
                ->where('i.id LIKE :search')
                ->orWhere('i.name LIKE :search')
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
            $this->createQueryBuilder('i')
                ->orderBy("i.{$orderBy}", $descending ? 'DESC' : 'ASC')
                ->where('i.id LIKE :search')
                ->orWhere('i.name LIKE :search')
                ->setParameter('search', "%{$search}%")
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function remove(Item $item): void
    {
        $this->em->remove($item);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('i')
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
}
