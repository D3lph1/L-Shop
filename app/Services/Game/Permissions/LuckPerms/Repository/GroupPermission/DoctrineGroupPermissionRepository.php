<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\GroupPermission;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineGroupPermissionRepository implements GroupPermissionRepository
{
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

    public function findAll(): array
    {
        return $this->er->findAll();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('gp')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
