<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LangController extends Controller
{
    public function js()
    {
        $locale = config('app.locale');

        $files = glob(resource_path('lang/' . $locale . '/*.php'));
        $data = [];

        foreach ($files as $file) {
            $name = basename($file, '.php');
            $data[$name] = __($name);
        }

        $response = new Response('window.i18n=' . json_encode($data) . ';');
        $response->header('Content-Type', 'text/javascript');

        return $response;
    }
}
