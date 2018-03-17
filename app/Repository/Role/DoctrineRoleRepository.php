<?php
declare(strict_types = 1);

namespace App\Repository\Role;

use App\Entity\Role;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRoleRepository implements RoleRepository
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

    public function findByName(string $name): ?Role
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['name' => $name]);
    }

    /**
     * {@inheritdoc}
     */
    public function findWhereNameIn(array $names): array
    {
        return $this->er->createQueryBuilder('r')
            ->where('r.name IN (:names)')
            ->setParameter('names', $names)
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findByAll(): array
    {
        return $this->er->findAll();
    }

    public function create(Role $role): void
    {
        $this->em->persist($role);
        $this->em->flush();
    }

    public function update(Role $role): void
    {
        $this->em->merge($role);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('r')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
