<?php

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\Admin\News as DTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedNewsRequest;
use App\Services\News;
use Illuminate\Http\Request;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\News
 */
class AddController extends Controller
{
    /**
     * Render the add news page.
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render(Request $request)
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.news.add', $data);
    }

    /**
     * Save the added news.
     *
     * @param SaveAddedNewsRequest $request
     * @param News                 $news Service - handler
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(SaveAddedNewsRequest $request, News $news)
    {
        $dto = new DTO(
            $request->get('news_title'),
            $request->get('news_content')
        );
        $dto->setUserId($this->sentinel->getUser()->getUserId());

        if (!$news->add($dto)) {
            $this->msg->success(__('messages.admin.news.add.success'));

            return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
        }
        $this->msg->danger(__('messages.admin.news.add.fail'));

        return back();
    }
}
