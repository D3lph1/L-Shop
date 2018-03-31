<?php
declare(strict_types = 1);

namespace App\Repository\Distribution;

use App\Entity\Distribution;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineDistributionRepository implements DistributionRepository
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

    public function create(Distribution $distribution): void
    {
        $this->em->persist($distribution);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('d')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
