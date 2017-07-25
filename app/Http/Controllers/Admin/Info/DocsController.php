<?php

namespace App\Http\Controllers\Admin\Info;

use Illuminate\Filesystem\Filesystem;
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
     * @var Filesystem
     */
    private $file;

    /**
     * @var \Parsedown
     */
    private $parsedown;

    public function __construct()
    {
        parent::__construct();
        $this->file = $this->app->make('files');
        $this->parsedown = $this->app->make(\Parsedown::class);
    }

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
        return view('admin.info.docs.main', [
            'data' => $this->parsedown->parse($this->load('main'))
        ]);
    }

    /**
     * Render page with L-Shop API documentation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function api()
    {
        return view('admin.info.docs.api', [
            'data' => $this->parsedown->parse($this->load('api'))
        ]);
    }

    /**
     * Render page with Sashok724's integration guide.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sashokLauncherIntegration()
    {
        return view('admin.info.docs.sashok_launcher_integration', [
            'data' => $this->parsedown->parse($this->load('sashok_launcher_integration'))
        ]);
    }

    /**
     * Render page with L-Shop CLI documentation.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cli()
    {
        return view('admin.info.docs.cli', [
            'data' => $this->parsedown->parse($this->load('cli'))
        ]);
    }

    private function load($name)
    {
        $locale = $this->app->getLocale();

        return $this->file->get($this->app->resourcePath("documentation/{$locale}/{$name}.md"));
    }
}
