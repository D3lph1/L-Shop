<?php
declare(strict_types = 1);

namespace App\Repository\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineUserRepository implements UserRepository
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

    public function create(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function update(User $user): void
    {
        $this->em->merge($user);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('u')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findById(int $id): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function findByUsername(string $username): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['username' => $username]);
    }

    public function findByEmail(string $email): ?User
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['email' => $email]);
    }
}
