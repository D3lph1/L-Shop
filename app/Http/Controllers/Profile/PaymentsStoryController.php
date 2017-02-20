<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentsStoryController extends Controller
{
    public function render(Request $request)
    {
        return view('profile.payments_story');
    }
}
