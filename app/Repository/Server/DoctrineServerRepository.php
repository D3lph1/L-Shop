<?php
declare(strict_types = 1);

namespace App\Repository\Server;

use App\Entity\Server;
use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineServerRepository implements ServerRepository
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

    public function create(Server $server): void
    {
        $this->clearResultCache();
        $this->em->persist($server);
        $this->em->flush();
    }

    public function update(Server $server): void
    {
        $this->clearResultCache();
        $this->em->merge($server);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function find(int $id): ?Server
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this
            ->er
            ->createQueryBuilder('server')
            ->select(['server', 'categories'])
            ->leftJoin('server.categories', 'categories')
            ->where('server.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findWithEnabledMonitoring(): array
    {
        return $this->er->createQueryBuilder('server')
            ->select('server')
            ->where('server.monitoringEnabled = 1')
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * @return Server[]
     */
    public function findAll(): array
    {
        return $this
            ->er
            ->createQueryBuilder('server')
            ->select('server')
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
