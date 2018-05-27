<?php
declare(strict_types = 1);

namespace App\Repository\Role;

use App\Entity\Role;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRoleRepository implements RoleRepository
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

    public function create(Role $role): void
    {
        $this->clearResultCache();
        $this->em->persist($role);
        $this->em->flush();
    }

    public function update(Role $role): void
    {
        $this->clearResultCache();
        $this->em->merge($role);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('r')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByName(string $name): ?Role
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('role')
            ->select('role')
            ->where('role.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findWhereIdIn(array $identifiers): array
    {
        return $this->er->createQueryBuilder('role')
            ->where('role.id IN (:identifiers)')
            ->setParameter('identifiers', $identifiers)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findWhereNameIn(array $names): array
    {
        return $this->er->createQueryBuilder('role')
            ->select('role')
            ->where('role.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findByAll(): array
    {
        return $this
            ->er
            ->createQueryBuilder('role')
            ->select('role')
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
