<?php
declare(strict_types = 1);

namespace App\Services\Settings\Repository\Doctrine;

use App\Services\Caching\CachingOptions;
use App\Services\Caching\ClearsCache;
use App\Services\Settings\Repository\Repository;
use App\Services\Settings\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class DoctrineRepository
 * The repository stores settings using the Doctrine ORM. This implementation uses
 * the results cache of the doctrine, in order to reduce the number of calls to
 * the database to read the settings.
 */
class DoctrineRepository implements Repository
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

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->er->createQueryBuilder('s')
            ->select()
            ->getQuery()
            ->useResultCache($this->cachingOptions->isEnabled(), $this->cachingOptions->getLifetime())
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function create(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->persist($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->merge($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Setting $setting): void
    {
        $this->clearResultCache();
        $this->em->remove($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAll(): bool
    {
        $this->clearResultCache();

        return (bool)$this->er->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
