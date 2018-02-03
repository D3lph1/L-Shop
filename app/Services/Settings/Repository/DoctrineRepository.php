<?php
declare(strict_types = 1);

namespace App\Services\Settings\Repository\Doctrine;

use App\Services\Settings\Repository\Repository;
use App\Services\Settings\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

class DoctrineRepository implements Repository
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

    public function findAll(): array
    {
        return $this->er->findAll();
    }

    public function create(Setting $setting): void
    {
        $this->em->persist($setting);
        $this->em->flush();
    }

    public function update(Setting $setting): void
    {
        $this->em->merge($setting);
        $this->em->flush();
    }

    public function delete(Setting $setting): void
    {
        $this->em->remove($setting);
        $this->em->flush();
    }

    public function deleteAll(): bool
    {
        return (bool)$this->er->createQueryBuilder('s')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}
