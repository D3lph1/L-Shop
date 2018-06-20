<?php
declare(strict_types = 1);

namespace App\Repository\Throttle;

use App\Entity\Throttle;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Psr\Log\LoggerInterface;

class DoctrineThrottleRepository implements ThrottleRepository
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

    public function create(Throttle $throttle): void
    {
        $this->em->persist($throttle);
        $this->em->flush();
    }

    public function countGlobalNotExpired(\DateTimeImmutable $datetime): int
    {
        return (int)$this->er->createQueryBuilder('throttle')
            ->select('COUNT(throttle.id)')
            ->where('throttle.user IS NULL')
            ->andWhere('throttle.ip IS NULL')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function minGlobalExpiration(\DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.user IS NULL')
            ->andWhere('throttle.ip IS NULL')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function countIpNotExpired(string $ip, \DateTimeImmutable $datetime): int
    {
        return (int)$this->er->createQueryBuilder('throttle')
            ->select('COUNT(throttle.id)')
            ->where('throttle.ip = :ip')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('ip', $ip)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function minIpExpiration(string $ip, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.ip = :ip')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('ip', $ip)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function countUserNotExpired(User $user, \DateTimeImmutable $datetime): int
    {
        return (int)$this->er->createQueryBuilder('throttle')
            ->select('COUNT(throttle.id)')
            ->where('throttle.user = :user')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('user', $user)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function minUserExpiration(User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.user = :user')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('user', $user)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function minGlobalAndIpAndUserExpiration(string $ip, User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.ip = :ip')
            ->andWhere('throttle.user = :user')
            ->andWhere('throttle.user IS NULL AND throttle.ip IS NULL')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('ip', $ip)
            ->setParameter('user', $user)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function minGlobalAndUserExpiration(User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.user = :user')
            ->andWhere('throttle.user IS NULL AND throttle.ip IS NULL')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('ip', $user)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function minGlobalAndIpExpiration(string $ip, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.ip = :ip')
            ->andWhere('throttle.user IS NULL AND throttle.ip IS NULL')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('ip', $ip)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function minIpAndUserExpiration(string $ip, User $user, \DateTimeImmutable $datetime): ?\DateTimeImmutable
    {
        $datetime = $this->er->createQueryBuilder('throttle')
            ->select('MIN(throttle.until)')
            ->where('throttle.user = :user')
            ->andWhere('throttle.ip = :ip')
            ->andWhere('throttle.until > :datetime')
            ->setParameter('user', $user)
            ->setParameter('ip', $ip)
            ->setParameter('datetime', $datetime)
            ->getQuery()
            ->getSingleScalarResult();

        return $datetime !== null ? new \DateTimeImmutable($datetime) : null;
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('t')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
