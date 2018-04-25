<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\Group;

use App\Services\Game\Permissions\LuckPerms\Entity\Group;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineGroupRepository implements GroupRepository
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

    public function create(Group $group): void
    {
        $this->em->persist($group);
        $this->em->flush();
    }

    public function findByName(string $name): ?Group
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['name' => $name]);
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('g')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
