<?php
declare(strict_types = 1);

namespace App\Repository\Category;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineCategoryRepository implements CategoryRepository
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

    public function create(Category $category): void
    {
        $this->em->persist($category);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('c')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(): array
    {
        return $this->er->findAll();
    }
}
