<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\PlayerPermission;

use App\Services\Game\Permissions\LuckPerms\Entity\PlayerPermission;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePlayerPermissionRepository implements PlayerPermissionRepository
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

    public function create(PlayerPermission $permission): void
    {
        $this->em->persist($permission);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('gp')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
