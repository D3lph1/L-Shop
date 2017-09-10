<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Services\Message;
use App\Traits\Validator;
use Cartalyst\Sentinel\Sentinel;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * Class Controller
 *
 * @author D3lph1 <d3lph1.contact@gmail.com>
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, Validator;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Sentinel
     */
    protected $sentinel;

    /**
     * @var Message
     */
    protected $msg;

    public function __construct()
    {
        $this->app = Container::getInstance()->make('app');
        $this->sentinel = $this->app->make('sentinel');
        $this->msg = $this->app->make('message');
    }
}
