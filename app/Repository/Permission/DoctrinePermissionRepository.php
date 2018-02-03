<?php
declare(strict_types = 1);

namespace App\Repository\Permission;

use App\Entity\Permission;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePermissionRepository implements PermissionRepository
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

    public function create(Permission $permission): void
    {
        $this->em->persist($permission);
        $this->em->flush();
    }

    public function update(Permission $permission): void
    {
        $this->em->merge($permission);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByName(string $name): ?Permission
    {
        return $this->er->findOneBy(['name' => $name]);
    }
}
