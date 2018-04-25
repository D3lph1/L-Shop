<?php
declare(strict_types = 1);

namespace App\Services\Game\Permissions\LuckPerms\Repository\Player;

use App\Services\Game\Permissions\LuckPerms\Entity\Player;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrinePlayerRepository implements PlayerRepository
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

    public function create(Player $player): void
    {
        $this->em->persist($player);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('p')
            ->delete()
            ->getQuery()
            ->getResult();
    }

    public function findByUsername(string $username): ?Player
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->er->findOneBy(['username' => $username]);
    }
}
