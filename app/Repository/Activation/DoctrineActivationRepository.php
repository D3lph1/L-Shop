<?php
declare(strict_types = 1);

namespace App\Repository\Activation;

use App\Entity\Activation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineActivationRepository implements ActivationRepository
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

    public function create(Activation $activation): void
    {
        $this->em->persist($activation);
        $this->em->flush();
    }

    public function update(Activation $activation): void
    {
        $this->em->merge($activation);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('a')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByUser(User $user): array
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findBy(['user' => $user]);
    }

    public function findByCode(string $code): ?Activation
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['code' => $code]);
    }

    public function deleteByUser(User $user): void
    {
        $this->er
            ->createQueryBuilder('r')
            ->where('r.user = :user')
            ->delete()
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}
