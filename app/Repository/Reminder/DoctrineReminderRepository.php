<?php
declare(strict_types = 1);

namespace App\Repository\Reminder;

use App\Entity\Reminder;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineReminderRepository implements ReminderRepository
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

    public function create(Reminder $reminder): void
    {
        $this->em->persist($reminder);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('r')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByCode(string $code): ?Reminder
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['code' => $code]);
    }

    public function remove(Reminder $reminder): void
    {
        $this->em->remove($reminder);
        $this->em->flush();
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
