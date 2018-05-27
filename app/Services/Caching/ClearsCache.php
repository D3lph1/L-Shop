<?php
declare(strict_types = 1);

namespace App\Services\Caching;

use Doctrine\ORM\EntityManagerInterface;

trait ClearsCache
{
    public function clearResultCache(): void
    {
        $cache = $this->getEntityManager()->getConfiguration()->getResultCacheImpl();
        if ($cache !== null && method_exists($cache, 'deleteAll')) {
            $cache->deleteAll();
        }
    }

    public function deleteResultCache(string $key): bool
    {
        $cache = $this->getEntityManager()->getConfiguration()->getResultCacheImpl();
        if ($cache !== null) {
            return $cache->delete($key);
        }

        return false;
    }

    abstract protected function getEntityManager(): EntityManagerInterface;
}
