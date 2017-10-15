<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Products;

use App\DataTransferObjects\Product;
use App\Exceptions\Product\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedProductRequest;
use App\TransactionScripts\Products;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Products
 */
class EditController extends Controller
{
    /**
     * Render the edit given product page.
     */
    public function render(Request $request, Products $script): View
    {
        $dto = null;

        try {
            $dto = $script->informationForEdit((int)$request->route('product'));
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'product' => $dto->getProduct(),
            'items' => $dto->getItems(),
            'categories' => $dto->getCategories(),
            'category' => $dto->getCategory()
        ];

        return view('admin.products.edit', $data);
    }

    /**
     * Save edited product.
     */
    public function save(SaveEditedProductRequest $request, Products $script): RedirectResponse
    {
        $dto = (new Product())
            ->setPrice((float)$request->get('price'))
            ->setStack((float)$request->get('stack'))
            ->setItemId((int)$request->get('item'))
            ->setServerId((int)$request->get('server'))
            ->setCategoryId((int)$request->get('category'))
            ->setSortPriority((float)$request->get('sort_priority'));

        $result = $script->edit((int)$request->route('product'), $dto);

        if ($result) {
            $this->msg->success(__('messages.admin.products.edit.success'));
        } else {
            $this->msg->danger(__('messages.admin.products.edit.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->getId()]);
    }

    /**
     * Remove product.
     */
    public function remove(Request $request, Products $script): RedirectResponse
    {
        $productId = (int)$request->route('product');
        $result = $script->delete($productId);

        if ($result) {
            $this->msg->info(__('messages.admin.products.remove.success'));
        } else {
            $this->msg->danger(__('messages.admin.products.remove.fail'));
        }

        return response()->redirectToRoute('admin.products.list', ['server' => $request->get('currentServer')->getId()]);
    }
}
