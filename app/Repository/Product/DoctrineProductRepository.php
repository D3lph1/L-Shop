<?php
declare(strict_types = 1);

namespace App\Repository\Product;

use App\Entity\Category;
use App\Entity\Product;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

class DoctrineProductRepository implements ProductRepository
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

    public function create(Product $product): void
    {
        $this->clearResultCache();
        $this->em->persist($product);
        $this->em->flush();
    }

    public function update(Product $product): void
    {
        $this->clearResultCache();
        $this->em->merge($product);
        $this->em->flush();
    }

    public function remove(Product $product): void
    {
        $this->clearResultCache();
        $this->em->remove($product);
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

    public function find(int $id): ?Product
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('product')
            ->select(['product', 'item'])
            ->join('product.item', 'item')
            ->where('product.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findForCategoryPaginated(Category $category, string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('product')
                ->select(['product', 'item', 'enchantmentItems', 'enchantment'])
                ->join('product.item', 'item')
                ->leftJoin('item.enchantmentItems', 'enchantmentItems')
                ->leftJoin('enchantmentItems.enchantment', 'enchantment')
                ->where('product.category = :category')
                ->andWhere('product.hidden = false')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->setParameter('category', $category)
                ->getQuery()
                ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime()),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginated(int $perPage): LengthAwarePaginator
    {
        return $this->paginateAll($perPage, 'page');
    }

    public function findPaginatedWithOrder(string $orderBy, bool $descending, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('product')
                ->join('product.item', 'item')
                ->join('product.category', 'category')
                ->join('category.server', 'server')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->getQuery(),
            $perPage,
            'page',
            false
        );
    }

    public function findPaginateWithSearch(string $search, int $perPage): LengthAwarePaginator
    {
        return $this->paginate(
            $this->createQueryBuilder('product')
                ->join('product.item', 'item')
                ->join('product.server', 'server')
                ->join('server.category', 'category')
                ->where('p.id LIKE :search')
                ->orWhere('product.price LIKE :search')
                ->orWhere('product.stack LIKE :search')
                ->orWhere('item.id LIKE :search')
                ->orWhere('item.name LIKE :search')
                ->orWhere('server.name LIKE :search')
                ->orWhere('category.name LIKE :search')
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
            $this->createQueryBuilder('product')
                ->orderBy($orderBy, $descending ? 'DESC' : 'ASC')
                ->join('product.item', 'item')
                ->join('product.category', 'category')
                ->join('category.server', 'server')
                ->where('product.id LIKE :search')
                ->orWhere('product.price LIKE :search')
                ->orWhere('product.stack LIKE :search')
                ->orWhere('item.id LIKE :search')
                ->orWhere('item.name LIKE :search')
                ->orWhere('server.name LIKE :search')
                ->orWhere('category.name LIKE :search')
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

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
