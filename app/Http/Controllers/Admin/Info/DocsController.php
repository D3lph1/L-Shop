<?php

namespace App\Http\Controllers\Admin\Info;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class DocsController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Info
 */
class DocsController extends Controller
{
    /**
     * Render the documentation menu page.
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

        return view('admin.info.docs', $data);
    }

    /**
     * Render page with main documentation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function main()
    {
        return view('admin.info.docs.main');
    }

    /**
     * Render page with L-Shop API documentation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function api()
    {
        return view('admin.info.docs.api');
    }

    /**
     * Render page with Sashok724's integration guide.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sashokLauncherIntegration()
    {
        return view('admin.info.docs.sashok_launcher_intagration');
    }

    /**
     * Render page with L-Shop CLI documentation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cli()
    {
        return view('admin.info.docs.cli');
    }
}
