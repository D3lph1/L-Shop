<?php
declare(strict_types=1);

namespace App\Repository\Persistence;

use App\Entity\Persistence;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePersistenceRepository implements PersistenceRepository
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

    public function create(Persistence $persistence): void
    {
        $this->em->persist($persistence);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByCode(string $code): ?Persistence
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['code' => $code]);
    }

    public function findByUser(User $user): array
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findBy(['user' => $user]);
    }

    public function deleteByCode(string $code): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->where('p.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getResult();
    }

    public function deleteByUser(User $user): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->where('p.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
