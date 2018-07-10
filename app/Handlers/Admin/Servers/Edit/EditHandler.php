<?php
declare(strict_types = 1);

namespace App\Handlers\Admin\Servers\Edit;

use App\DataTransferObjects\Admin\Servers\Edit\Edit;
use App\Entity\Category;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Distributor\DistributorNotFoundException;
use App\Exceptions\Server\ServerNotFoundException;
use App\Repository\Category\CategoryRepository;
use App\Repository\Server\ServerRepository;
use Illuminate\Contracts\Config\Repository;

class EditHandler
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var Repository
     */
    private $config;

    public function __construct(ServerRepository $serverRepository, CategoryRepository $categoryRepository, Repository $config)
    {
        $this->serverRepository = $serverRepository;
        $this->categoryRepository = $categoryRepository;
        $this->config = $config;
    }

    public function handle(Edit $dto): void
    {
        $server = $this->serverRepository->find($dto->getId());
        if ($server === null) {
            throw ServerNotFoundException::byId($dto->getId());
        }

        $oldCategories = clone $server->getCategories();

        foreach ($dto->getCategories() as $category) {
            if ($category->getId() === null) {
                $newCategory = new Category($category->getName(), $server);
                $server->getCategories()->add($newCategory);
            } else {
                $filtered = $server->getCategories()->filter(function (Category $each) use ($category) {
                    return $each->getId() === $category->getId();
                });
                if ($filtered->count() === 0) {
                    throw CategoryNotFoundException::byId($category->getId());
                }

                $editedCategory = $filtered->first();
                $editedCategory->setName($category->getName());
                $this->categoryRepository->update($editedCategory);

                $oldCategories->removeElement($editedCategory);
            }
        }

        foreach ($oldCategories as $oldCategory) {
            $this->categoryRepository->remove($oldCategory);
        }

        if (!in_array($dto->getDistributor(), $this->config->get('purchasing.distribution.distributors'))) {
            throw new DistributorNotFoundException("Distributor {$dto->getDistributor()} does not registered in system");
        }

        $server
            ->setName($dto->getName())
            ->setIp($dto->getIp())
            ->setPort($dto->getPort())
            ->setPassword($dto->getPassword())
            ->setMonitoringEnabled($dto->isMonitoringEnabled())
            ->setEnabled($dto->isServerEnabled())
            ->setDistributor($dto->getDistributor());

        $this->serverRepository->update($server);
    }
}
