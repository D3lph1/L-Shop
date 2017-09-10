<?php

namespace App\Http\Controllers\Admin\Info;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

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
     */
    public function render(Request $request): View
    {
        $data = [
            'currentServer' => $request->get('currentServer')
        ];

        return view('admin.info.docs', $data);
    }

    /**
     * Render page with main documentation.
     */
    public function main(): View
    {
        return view('admin.info.docs.main', [
            'data' => $this->parsedown->parse($this->load('main'))
        ]);
    }

    /**
     * Render page with L-Shop API documentation.
     */
    public function api(): View
    {
        return view('admin.info.docs.api', [
            'data' => $this->parsedown->parse($this->load('api'))
        ]);
    }

    /**
     * Render page with Sashok724's integration guide.
     */
    public function sashokLauncherIntegration(): View
    {
        return view('admin.info.docs.sashok_launcher_integration', [
            'data' => $this->parsedown->parse($this->load('sashok_launcher_integration'))
        ]);
    }

    /**
     * Render page with L-Shop CLI documentation.
     */
    public function cli(): View
    {
        return view('admin.info.docs.cli', [
            'data' => $this->parsedown->parse($this->load('cli'))
        ]);
    }

    /**
     * Load file with documentations.
     *
     * @param string $name
     *
     * @return string
     */
    private function load(string $name): string
    {
        $locale = $this->app->getLocale();
        $path = $this->app->resourcePath("documentation/{$locale}/{$name}.md");
        if ($this->file->exists($path)) {
            return $this->file->get($path);
        }
        $fallback = 'ru';

        return $this->file->get($this->app->resourcePath("documentation/{$fallback}/{$name}.md"));
    }
}
