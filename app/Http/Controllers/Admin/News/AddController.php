<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\Admin\News as DTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedNewsRequest;
use App\Services\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class AddController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\News
 */
class AddController extends Controller
{
    /**
     * Render the add news page.
     */
    public function render(Request $request): View
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.news.add', $data);
    }

    /**
     * Save the added news.
     */
    public function save(SaveAddedNewsRequest $request, News $news): RedirectResponse
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
