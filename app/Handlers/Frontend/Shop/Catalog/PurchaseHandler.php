<?php
declare(strict_types = 1);

namespace App\Handlers\Frontend\Shop\Catalog;

use App\DataTransferObjects\Frontend\Shop\Catalog\Purchase as ResultDTO;
use App\DataTransferObjects\Frontend\Shop\Purchase;
use App\Exceptions\ForbiddenException;
use App\Exceptions\Product\ProductNotFoundException;
use App\Repository\Product\ProductRepository;
use App\Services\Auth\Auth;
use App\Services\Auth\Permissions;
use App\Services\Purchasing\PurchaseProcessor;
use App\Services\Server\ServerAccess;

class PurchaseHandler
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var PurchaseProcessor
     */
    private $processor;

    public function __construct(Auth $auth, ProductRepository $productRepository, PurchaseProcessor $processor)
    {
        $this->auth = $auth;
        $this->productRepository = $productRepository;
        $this->processor = $processor;
    }

    /**
     * @param int         $productId
     * @param int         $amount
     * @param null|string $username
     * @param string      $ip
     *
     * @return ResultDTO
     *
     * @throws ProductNotFoundException
     * @throws ForbiddenException
     */
    public function handle(int $productId, int $amount, ?string $username, string $ip): ResultDTO
    {
        $product = $this->productRepository->find($productId);
        if ($product === null) {
            throw ProductNotFoundException::byId($productId);
        }
        $server = $product->getCategory()->getServer();
        if (!ServerAccess::isUserHasAccessTo($this->auth->getUser(), $server)) {
            throw new ForbiddenException("Server {$server} is disabled and the user does not have permissions to make a purchase");
        }

        if ($product->isHidden() && !($this->auth->check() && $this->auth->getUser()->hasPermission(Permissions::ACCESS_TO_HIDDEN_PRODUCTS))) {
            throw new ForbiddenException("Product {$product} is hidden and the user does not have permissions to make a purchase");
        }

        $DTO = new Purchase($product, $amount);

        return $this->processor->process([$DTO], $username, $ip);
    }
}
