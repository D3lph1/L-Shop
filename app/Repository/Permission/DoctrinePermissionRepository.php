<?php
declare(strict_types = 1);

namespace App\Repository\Permission;

use App\Entity\Permission;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePermissionRepository implements PermissionRepository
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

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
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
            ->getResult();
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

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
