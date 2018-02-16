<?php
declare(strict_types = 1);

namespace App\Http\Controllers;

class SpaController extends Controller
{
    public function render()
    {
        return view('app');
    }
}
