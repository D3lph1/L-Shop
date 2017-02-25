<?php

namespace App\Http\Controllers\Admin\Servers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EditController extends Controller
{
    public function render()
    {
        $servers = $this->qm->serversWithCategories([
            'servers.id',
            'servers.name',
            'servers.enabled'
        ]);

        $data = [
            'servers' => $servers
        ];

        return view('admin.servers.edit', $data);
    }
}
