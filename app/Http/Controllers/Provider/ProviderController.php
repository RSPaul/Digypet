<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    //

    public function __construct() {
        $this->middleware(['auth','provider']);
    }

    public function dashboard(Request $request) {
    	return view('provider.dashboard');
    }
}
