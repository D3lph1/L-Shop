<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\News;

use App\DataTransferObjects\News as DTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SaveAddedNewsRequest;
use App\Models\News\NewsInterface;
use App\Traits\ContainerTrait;
use App\TransactionScripts\Shop\News;
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
    use ContainerTrait;

    /**
     * Render the add news page.
     */
    public function render(Request $request): View
    {
        return view('admin.news.add', [
            'currentServer' => $request->get('currentServer')
        ]);
    }

    /**
     * Save the added news.
     */
    public function save(SaveAddedNewsRequest $request, News $news): RedirectResponse
    {
        $entity = $this->make(NewsInterface::class)
            ->setTitle($request->get('news_title'))
            ->setContent($request->get('news_content'))
            ->setUserId($this->sentinel->getUser()->getUserId());

        if ($news->create($entity)) {
            $this->msg->success(__('messages.admin.news.add.success'));

            return response()->redirectToRoute('admin.news.list', ['server' => $request->get('currentServer')->id]);
        }
        $this->msg->danger(__('messages.admin.news.add.fail'));

        return back();
    }
}
