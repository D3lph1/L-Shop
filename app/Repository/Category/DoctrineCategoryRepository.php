<?php
declare(strict_types = 1);

namespace App\Repository\Category;

use App\Entity\Category;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineCategoryRepository implements CategoryRepository
{
    use ClearsCache;

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

    public function create(Category $category): void
    {
        $this->clearResultCache();
        $this->em->persist($category);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('category')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?Category
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('category')
            ->select('category')
            ->where('category.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache(true)
            ->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this
            ->er
            ->createQueryBuilder('category')
            ->select('category')
            ->getQuery()
            ->useResultCache(true)
            ->getResult();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
