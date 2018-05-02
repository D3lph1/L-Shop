<?php
declare(strict_types = 1);

namespace App\Services\Settings\Repository\Doctrine;

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
    /**
     * Settings cache lifetime (in seconds).
     */
    private const CACHE_LIFETIME = 60 * 60;

    /**
     * The name of the key under which the cache settings will be stored.
     */
    private const CACHE_KEY = 'settings';

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

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->er->createQueryBuilder('s')
            ->select()
            ->getQuery()
            ->useResultCache(true, self::CACHE_LIFETIME, self::CACHE_KEY)
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function create(Setting $setting): void
    {
        $this->clearCache();
        $this->em->persist($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function update(Setting $setting): void
    {
        $this->clearCache();
        $this->em->merge($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Setting $setting): void
    {
        $this->clearCache();
        $this->em->remove($setting);
        $this->em->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function deleteAll(): bool
    {
        $this->clearCache();

        return (bool)$this->er->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    private function clearCache(): void
    {
        $cache = $this->em->getConfiguration()->getResultCacheImpl();
        if ($cache !== null) {
            $cache->delete(self::CACHE_KEY);
        }
    }
}
