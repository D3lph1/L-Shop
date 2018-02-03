<?php
declare(strict_types = 1);

namespace App\Repository\Item;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineItemRepository implements ItemRepository
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

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('i')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
