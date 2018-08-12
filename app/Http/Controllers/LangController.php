<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Handlers\LangHandler;
use Illuminate\Http\Response;

/**
 * Class LangController
 * The controller is used to localize the application on the frontend.
 */
class LangController extends Controller
{
    /**
     * Returns the data for localization as a javascript piece of code. Thus, this action
     * can be used as an included javascript file.
     *
     * @param LangHandler $handler
     *
     * @return Response
     */
    public function js(LangHandler $handler): Response
    {
        $response = new Response('window.i18n=' . json_encode($handler->handle()) . ';');
        $response->header('Content-Type', 'text/javascript');

        return $response;
    }
}
