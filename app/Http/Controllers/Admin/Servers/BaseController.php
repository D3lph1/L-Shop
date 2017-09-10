<?php
declare(strict_types = 1);

namespace App\Http\Controllers\Admin\Servers;

use App\Repositories\ServerRepository;
use App\Services\Server;
use App\Http\Controllers\Controller;

/**
 * Class BaseController
 *
 * @author  D3lph1 <d3lph1.contact@gmail.com>
 * @package App\Http\Controllers\Admin\Servers
 */
class BaseController extends Controller
{
    /**
     * @var Server
     */
    protected $serverService;

    /**
     * @var ServerRepository
     */
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
