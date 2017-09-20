<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Page as DTO;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedPageRequest;
use App\TransactionScripts\Pages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Pages
 */
class AddController extends Controller
{
    /**
     * Render add static page.
     */
    public function render(Request $request): View
    {
        return view('admin.pages.add', [
            'currentServer' => $request->get('currentServer')
        ]);
    }

    /**
     * Save new static page.
     */
    public function save(SaveAddedPageRequest $request, Pages $script): RedirectResponse
    {
        $page = (new DTO())
            ->setTitle($request->get('page_title'))
            ->setContent($request->get('page_content'))
            ->setUrl($request->get('page_url'));

        try {
            if ($script->create($page)) {
                $this->msg->success(__('messages.admin.pages.add.success'));
            } else {
                $this->msg->danger(__('messages.admin.pages.add.fail'));
            }
        } catch (UrlAlreadyExistsException $e) {
            $this->msg->warning(__('messages.admin.pages.url_already_exists'));

            return back();
        }

        return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->getId()]);
    }
}
