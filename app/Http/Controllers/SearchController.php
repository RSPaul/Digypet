<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class SearchController extends Controller
{
    //

    public function index() {
    	return view('search.index');
    }

    public function getProviders(){
    	$search = User::where(['type' => 'Provider', 'status' => 1])->get();
    	 foreach ($search as $key => $value) {
                                           # code...
                  $value->service_pricing    = unserialize($value->service_pricing); 
                  $value->pets  = unserialize($value->pets);   
                  $value->images  = unserialize($value->images);   
                  
        }    
    	return response()->json($search);
    }
}
