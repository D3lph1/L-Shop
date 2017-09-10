<?php

namespace App\Http\Controllers\Admin\Info;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

/**
 * Class AboutController
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers\Admin\Info
 */
class AboutController extends Controller
{
    /**
     * Render the about page.
     */
    public function render(): View
    {
        return view('admin.info.about');
    }
}
