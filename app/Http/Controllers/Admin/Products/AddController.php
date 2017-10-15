<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Product;
use App\Exceptions\ItemNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedProductRequest;
use App\Models\Product\ProductInterface;
use App\Repositories\Item\ItemRepositoryInterface;
use App\Repositories\Server\ServerRepositoryInterface;
use App\Traits\ContainerTrait;
use App\TransactionScripts\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Products
 */
class AddController extends Controller
{
    use ContainerTrait;

    /**
     * Render the add product page.
     */
    public function render(Request $request, ItemRepositoryInterface $itemRepository, ServerRepositoryInterface $serverRepository): View
    {
        $items = $itemRepository->all([
            'id',
            'name',
            'type'
        ]);

        $servers = $serverRepository->allWithCategories(['name'], ['id', 'name']);

        $data = [
            'currentServer' => $request->get('currentServer'),
            'items' => $items,
            'servers' => $servers
        ];

        return view('admin.products.add', $data);
    }

    /**
     * Save new product request.
     */
    public function save(SaveAddedProductRequest $request, Products $script): RedirectResponse
    {
        /** @var ProductInterface $entity */
        $entity = $this->make(ProductInterface::class);
        $entity
            ->setPrice((float)$request->get('price'))
            ->setStack((float)$request->get('stack'))
            ->setItemId((int)$request->get('item'))
            ->setServerId((int)$request->get('server'))
            ->setCategoryId((int)$request->get('category'))
            ->setSortPriority((float)$request->get('sort_priority'));

        $result = null;

        try {
            $result = $script->create($entity);
        } catch (ItemNotFoundException $e) {
            $this->msg->danger(__('messages.admin.products.add.item_not_found', ['id' => $dto->getItemId()]));
        }

        if ($result) {
            $this->msg->success(__('messages.admin.products.add.success'));
        }else {
            $this->msg->danger(__('messages.admin.products.add.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->id]);
    }
}
