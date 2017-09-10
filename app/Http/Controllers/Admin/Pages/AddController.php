<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Admin\Page as DTO;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Services\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedPageRequest;
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
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.pages.add', $data);
    }

    /**
     * Save new static page.
     */
    public function save(SaveAddedPageRequest $request, Page $handler): RedirectResponse
    {
        $page = new DTO(
            $request->get('page_title'),
            $request->get('page_content'),
            $request->get('page_url')
        );

        try {
            if ($handler->create($page)) {
                $this->msg->success(__('messages.admin.pages.add.success'));
            } else {
                $this->msg->danger(__('messages.admin.pages.add.fail'));
            }
        } catch (UrlAlreadyExistsException $e) {
            $this->msg->warning(__('messages.admin.pages.url_already_exists'));

            return back();
        }

        return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->id]);
    }
}
