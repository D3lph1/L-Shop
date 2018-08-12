<?php
declare(strict_types = 1);

namespace App\Services\Settings;

use App\Services\Settings\Repository\Repository;

class Driver
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function read(): array
    {
        return $this->repository->findAll();
    }

    /**
     * @param Setting[] $oldData
     * @param Setting[] $newData
     */
    public function write(array $oldData, array $newData): void
    {
        foreach ($oldData as $oldDatum) {
            $f = false;
            foreach ($newData as $newDatum) {
                if ($oldDatum->getKey() === $newDatum->getKey()) {
                    $f = true;
                    break;
                }
            }

            if (!$f) {
                $this->repository->remove($oldDatum);
                continue;
            }

            foreach ($newData as $newDatum) {
                if (
                    $oldDatum->getKey() === $newDatum->getKey()
                    &&
                    $oldDatum->getValue() != $newDatum->getValue()
                ) {
                    $this->repository->update($newDatum);
                }
            }
        }

        foreach ($newData as $newDatum) {
            $f = false;
            foreach ($oldData as $oldDatum) {
                if ($newDatum->getKey() === $oldDatum->getKey()) {
                    $f = true;
                    break;
                }
            }

            if (!$f) {
                $this->repository->create($newDatum);
            }
        }
    }
}
