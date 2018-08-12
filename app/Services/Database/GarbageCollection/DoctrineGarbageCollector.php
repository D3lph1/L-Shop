<?php
declare(strict_types = 1);

namespace App\Services\Database\GarbageCollection;

use Doctrine\ORM\EntityManagerInterface;

class DoctrineGarbageCollector implements GarbageCollector
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function collectAll(): void
    {
        $this->em->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function collectEntity($entity): void
    {
        $this->em->detach($entity);
    }
}
