<?php
declare(strict_types = 1);

namespace App\Repository\Ban;

use App\Entity\Ban;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineBanRepository implements BanRepository
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

    /**
     * {@inheritdoc}
     */
    public function remove(Ban $ban): void
    {
        $this->em->remove($ban);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('b')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
