<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Control\Optimization;

use App\Services\Caching\ClearsCache;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Console\Kernel;

class ResetAppCacheHandler
{
    use ClearsCache;

    /**
     * @var Kernel
     */
    private $console;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(Kernel $console, EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->console = $console;
    }

    public function handle(): void
    {
        $this->console->call('cache:clear');
        $this->clearResultCache();
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return $this->em;
    }
}
