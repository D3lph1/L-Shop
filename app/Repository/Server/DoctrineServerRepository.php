<?php
declare(strict_types = 1);

namespace App\Repository\Server;

use App\Entity\Server;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineServerRepository implements ServerRepository
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

    public function create(Server $server): void
    {
        $this->em->persist($server);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Server[]
     */
    public function findAll(): array
    {
        return $this->er->findAll();
    }

    public function find(int $id): ?Server
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }
}
