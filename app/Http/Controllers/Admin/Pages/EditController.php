<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Page as DTO;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedPageRequest;
use App\Services\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class EditController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Pages
 */
class EditController extends Controller
{
    /**
     * @var Page
     */
    private $page;

    /**
     * EditController constructor.
     *
     * @param Page $page
     */
    public function __construct(Page $page)
    {
        $this->page = $page;
        parent::__construct();
    }

    /**
     * Render the edit static page request.
     */
    public function render(Request $request): View
    {
        $id = (int)$request->route('id');
        $page = $this->page->getById($id, ['title', 'content', 'url']);

        if (!$page) {
            $this->app->abort(404);
        }

        $data = [
            'currentServer' => $request->get('currentServer'),
            'id' => $id,
            'page' => $page
        ];

        return view('admin.pages.edit', $data);
    }

    /**
     * Handle save edited static page request.
     */
    public function save(SaveEditedPageRequest $request): RedirectResponse
    {
        $page = (new DTO())
            ->setId((int)$request->route('id'))
            ->setTitle($request->get('page_title'))
            ->setContent($request->get('page_content'))
            ->setUrl($request->get('page_url'));

        $result = null;

        try {
            if ($this->page->update($page)) {
                $this->msg->success(__('messages.admin.pages.edit.success'));

                return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->id]);
            } else {
                $this->msg->danger(__('messages.admin.pages.edit.fail'));
            }
        } catch (UrlAlreadyExistsException $e) {
            $this->msg->warning(__('messages.admin.pages.url_already_exists'));
        }

        return back();
    }

    /**
     * Delete given static page.
     */
    public function delete(Request $request): RedirectResponse
    {
        $id = (int)$request->route('id');
        if ($this->page->delete($id)) {
            $this->msg->info(__('messages.admin.pages.delete.success'));

            return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->id]);
        }
        $this->msg->danger(__('messages.admin.pages.delete.fail'));

        return back();
    }
}
