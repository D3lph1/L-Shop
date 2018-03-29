<?php
declare(strict_types = 1);

namespace App\Repository\ShoppingCart;

use App\Entity\ShoppingCart;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineShoppingCartRepository implements ShoppingCartRepository
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

    public function create(ShoppingCart $entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
}
