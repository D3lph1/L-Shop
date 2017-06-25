<?php

namespace App\Http\Controllers\Admin\Servers;

use App\Repositories\ServerRepository;
use App\Services\Server;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    /**
     * @var Server
     */
    protected $serverService;

    protected $serverRepository;

    /**
     * BaseController constructor.
     *
     * @param Server           $server
     * @param ServerRepository $serverRepository
     */
    public function __construct(Server $server, ServerRepository $serverRepository)
    {
        $this->serverService = $server;
        $this->serverRepository = $serverRepository;

        parent::__construct();
    }
}
