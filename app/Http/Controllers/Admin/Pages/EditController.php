<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Pages;

use App\DataTransferObjects\Page as DTO;
use App\Exceptions\Page\NotFoundException;
use App\Exceptions\Page\UrlAlreadyExistsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveEditedPageRequest;
use App\TransactionScripts\Pages;
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
     * @var Pages
     */
    private $pages;

    /**
     * EditController constructor.
     *
     * @param Pages $page
     */
    public function __construct(Pages $page)
    {
        $this->pages = $page;
        parent::__construct();
    }

    /**
     * Render the edit static page request.
     */
    public function render(Request $request): View
    {
        $id = (int)$request->route('id');

        try {
            return view('admin.pages.edit', [
                'currentServer' => $request->get('currentServer'),
                'id' => $id,
                'page' => $this->pages->informationForEdit($id)
            ]);
        } catch (NotFoundException $e) {
            $this->app->abort(404);
        }

        // Unreachable statement. For IDE.
        return null;
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

        try {
            if ($this->pages->update($page)) {
                $this->msg->success(__('messages.admin.pages.edit.success'));

                return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->getId()]);
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
        if ($this->pages->delete($id)) {
            $this->msg->info(__('messages.admin.pages.delete.success'));

            return response()->redirectToRoute('admin.pages.list', ['server' => $request->get('currentServer')->getId()]);
        }
        $this->msg->danger(__('messages.admin.pages.delete.fail'));

        return back();
    }
}
