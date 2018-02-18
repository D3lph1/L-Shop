<?php
declare(strict_types=1);

namespace App\Handlers\Frontend\Shop\Catalog;

use App\DataTransferObjects\Frontend\Shop\Catalog\Category as CategoryDTO;
use App\DataTransferObjects\Frontend\Shop\Catalog\Product;
use App\DataTransferObjects\Frontend\Shop\Catalog\Result;
use App\DataTransferObjects\Frontend\Shop\Catalog\Server as ServerDTO;
use App\Entity\Category;
use App\Entity\Server;
use App\Repository\Product\ProductRepository;
use App\Services\Infrastructure\Server\Persistence\Persistence;
use App\Exceptions\Category\DoesNotExistException as CategoryDoesNotExistException;
use App\Exceptions\Server\DoesNotExistException as ServerDoesNotExistException;
use App\Repository\Server\ServerRepository;
use App\Services\Settings\DataType;
use App\Services\Settings\Settings;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VisitHandler
{
    /**
     * @var ServerRepository
     */
    private $serverRepository;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Persistence
     */
    private $persistence;

    public function __construct(
        ServerRepository $serverRepository,
        ProductRepository $productRepository,
        Settings $settings,
        Persistence $persistence)
    {
        $this->serverRepository = $serverRepository;
        $this->productRepository = $productRepository;
        $this->settings = $settings;
        $this->persistence = $persistence;
    }

    /**
     * @param int $serverId
     * @param int $categoryId
     *
     * @return Result
     * @throws ServerDoesNotExistException
     * @throws CategoryDoesNotExistException
     */
    public function handle(int $serverId, ?int $categoryId): Result
    {
        $server = $this->checkServerAndCategory($serverId, $categoryId);

        $currentCategory = $server->getCategories()->get(0);

        if ($categoryId !== 0) {
            /** @var Category $category */
            foreach ($server->getCategories() as $category) {
                if ($category->getId() === $categoryId) {
                    $currentCategory = $category;

                    break;
                }
            }
        }

        if ($currentCategory === null) {
            return new Result(new ServerDTO($server), null, [], null);
        }

        $paginator = $this->productRepository->findForCategoryPaginated(
            $currentCategory,
            $this->settings->get('system.catalog.pagination.per_page')->getValue(DataType::INT)
        );
        $products = $this->fromPaginatorToDTO($paginator);

        return new Result(new ServerDTO($server), new CategoryDTO($currentCategory), $products, $paginator);
    }

    /**
     * @param int      $serverId
     * @param int|null $categoryId
     *
     * @return Server
     * @throws ServerDoesNotExistException
     * @throws CategoryDoesNotExistException
     */
    private function checkServerAndCategory(int $serverId, ?int $categoryId): Server
    {
        $server = $this->serverRepository->find($serverId);
        if ($server === null) {
            throw new ServerDoesNotExistException($serverId);
        }

        if ($categoryId === 0) {
            $this->persistence->persist($server);

            return $server;
        }

        if (count($server->getCategories()) === 0 && $categoryId !== null) {
            throw new CategoryDoesNotExistException();
        }

        /** @var Category $category */
        foreach ($server->getCategories() as $category) {
            if ($category->getId() === $categoryId) {
                $this->persistence->persist($server);

                return $server;
            }
        }

        throw new CategoryDoesNotExistException($categoryId);
    }

    private function fromPaginatorToDTO(LengthAwarePaginator $paginator)
    {
        $products = $paginator->items();
        $result = [];
        foreach ($products as $product) {
            $result[] = new Product($product);
        }

        return $result;
    }
}
