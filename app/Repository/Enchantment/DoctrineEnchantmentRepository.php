<?php
declare(strict_types = 1);

namespace App\Repository\Enchantment;

use App\Entity\Enchantment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineEnchantmentRepository implements EnchantmentRepository
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

    public function create(Enchantment $enchantment): void
    {
        $this->em->persist($enchantment);
        $this->em->flush();
    }

    public function find(int $id): ?Enchantment
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->find($id);
    }

    public function findByGameId(int $gameId): ?Enchantment
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['gameId' => $gameId]);
    }

    public function findWhereIn(array $identifiers): array
    {
        return $this->er->createQueryBuilder('e')
            ->where('e.id IN (:identifiers)')
            ->setParameter('identifiers', $identifiers)
            ->getQuery()
            ->getResult();
    }

    /**
     * @inheritDoc
     */
    public function findAll(): array
    {
        return $this->er->findAll();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('e')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
