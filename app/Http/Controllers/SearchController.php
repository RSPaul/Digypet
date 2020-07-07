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

    public function filterProviders(Request $request){
    	if($request->isMethod('post')) {
    		$data = $request->all();
    		//print_r($data);
    		$search = User::where(['type' => 'Provider', 'status' => 1])->get();
    		$filterSearch = array();
    		$filterarray = array();
	    	foreach ($search as $key => $value) {
	                # code...
	                $value->pets  = unserialize($value->pets);  
		     		$value->service_pricing  = unserialize($value->service_pricing); 
		        	$value->images  = unserialize($value->images);	                  
	                foreach ($value->pets as $key1 => $value1) {
	                  	# code...
	                  	if(isset($data['servicetype']) && $data['servicetype'] != '' && isset($data['pettype']) && $data['pettype'] != ''){
	                  		 if($value1 && strpos($key1,$data['pettype']) !== false){
		                        foreach ($value->service_pricing as $key2 => $value2) {
			                  		if($value2 && strpos($key2,$data['servicetype']) !== false){
				                    	array_push($filterSearch , $value);
				                  	}
		                  		}	
		                  	 }
	                  	}else if(isset($data['pettype']) && $data['pettype'] != ''){

		                  if($value1 && strpos($key1,$data['pettype']) !== false){
		                    array_push($filterSearch , $value);
		                  }

	                  	}else if(isset($data['servicetype']) && $data['servicetype'] != ''){
	                  		foreach ($value->service_pricing as $key2 => $value2) {
		                  		if($value2 && strpos($key2,$data['servicetype']) !== false){
			                    	array_push($filterSearch , $value);
			                  	}
		                  	}	
	                  	}else{

	                  	}
	                }
	        }
	        $filterSearch = array_unique($filterSearch);
	        foreach ($filterSearch as $key => $value) {
	        	# code...
	       		 array_push($filterarray , $value);
	        }
	        return response()->json($filterarray);
    	}
    }
}
