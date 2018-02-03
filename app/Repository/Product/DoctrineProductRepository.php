<?php
declare(strict_types = 1);

namespace App\Repository\Product;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineProductRepository implements ProductRepository
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

    public function create(Product $product): void
    {
        $this->em->persist($product);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?Product
    {
        return $this->er->find($id);
    }

    public function findForCategoryPaginated(Category $category, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('p')
                ->where('p.category = :category')
                ->setParameter('category', $category)
                ->getQuery(),
            $perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function createQueryBuilder($alias, $indexBy = null)
    {
        return $this->er->createQueryBuilder($alias, $indexBy);
    }
}
