<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Services;
use App\User;
use App\PaymentDetails;

class ProviderController extends Controller
{
    //

    public function __construct() {
        $this->middleware(['auth','provider']);
    }

    public function dashboard(Request $request) {
    	return view('provider.dashboard');
    }

    public function addPetService(Request $request) {
    	if(Auth::check()) {
    		if($request->isMethod('post')) {
    			$data = $request->all();
    			$input = $request->only('pet_type', 'pet_icon', 'service_type', 'description' , 'price', 'price_per_unit', 'service_location', 'share_service', 'share_images', 'images');
    			try {
    				//upload image
	                if(isset($input['images']) && is_array($input['images'])) {
	                    $files = $data['images'];
	                    $counter=0;
	                    $images = array();
	                    foreach($files as $file) {
	                        if(strpos($file, "data:") !== false) {
	                            $file_date = $file;
	                            list($type, $file_date) = explode(';', $file_date);
	                            list(, $file_date)      = explode(',', $file_date);
	                            $file_date = base64_decode($file_date);
	                            $file_type = explode("/", $type);
	                            //print_r($file_type);die();
	                            $file_name = $counter.time().'.' . $file_type[1];
	                            $path = public_path() . "/uploads/providers/" . $file_name;
	                            file_put_contents($path, $file_date);
	                            array_push($images, $file_name);
	                            $counter++;

	                        } else {
	                            array_push($images, $file);
	                        }
	                    }
	                }   
	                $input['images'] = serialize($images);
	                $input['pet_icon'] = 'dog';
	                $input['user_id'] = Auth::user()->id;
	                Services::create($input);
	                $response = array('status' => true,
								  'message' => 'Pet Service Added.');
	                return response()->json($response);
    			} catch(Exception $e) {
    				return response()->json(array('status' => false, 'message' => $e->getMessage()));
    			}
    		}
    	}
    }

    public function updatePetService(Request $request){
    	 if(Auth::check()) {
    		if($request->isMethod('post')) {
    			$data = $request->all();
    			$input = $request->only('pet_type', 'pet_icon', 'service_type', 'description' , 'price', 'price_per_unit', 'service_location', 'share_service', 'share_images', 'images');
    			try {
    				//upload image
	                if(isset($input['images']) && is_array($input['images'])) {
	                    $files = $data['images'];
	                    $counter=0;
	                    $images = array();
	                    foreach($files as $file) {
	                        if(strpos($file, "data:") !== false) {
	                            $file_date = $file;
	                            list($type, $file_date) = explode(';', $file_date);
	                            list(, $file_date)      = explode(',', $file_date);
	                            $file_date = base64_decode($file_date);
	                            $file_type = explode("/", $type);
	                            //print_r($file_type);die();
	                            $file_name = $counter.time().'.' . $file_type[1];
	                            $path = public_path() . "/uploads/providers/" . $file_name;
	                            file_put_contents($path, $file_date);
	                            array_push($images, $file_name);
	                            $counter++;

	                        } else {
	                            array_push($images, $file);
	                        }
	                    }
	                }   
	                $input['images'] = serialize($images);
	                $input['pet_icon'] = 'dog';
	                $input['user_id'] = Auth::user()->id;
	                Services::where(['id' => $data['id']])
                        ->update($input);
	                $response = array('status' => true,
								  'message' => 'Pet Service Updated.');
	                return response()->json($response);
    			} catch(Exception $e) {
    				return response()->json(array('status' => false, 'message' => $e->getMessage()));
    			}
    		}
    	}	
    }

    public function services(Request $request) {
    	if(Auth::check()) {
    		$services = Services::where(['user_id' => Auth::user()->id])->orderBy('created_at')->get();
    		return response()->json(array('status' => true, 'services' => $services));
    	}
    }

    public function viewPetService(Request $request){
    	if(Auth::check()) {
    		$id = $request['id'];
    		$services = Services::where(['id' => $id])->first();
    		$services['images'] = unserialize($services['images']);
    		return response()->json(array('status' => true, 'services' => $services));
    	}
    }

    public function deletePetService(Request $request){
    	if(Auth::check()) {
    		$id = $request['id'];
    		Services::where(['id' => $id])->delete();
    		$response = array('status' => true,
							  'message' => 'Service deleted.');
    		return response()->json($response);
    	}
    }

    public function getBankAccount(){
    	if(Auth::check()) {
    		$details = PaymentDetails::where(['user_id' => Auth::user()->id])->first();
	        $request_data = array('account_type' => '',
	                                'name' => '',
	                                'routing_number' => '',
	                                'account_number' => '',
	                                'day' => '',
	                                'month' => '',
	                                'year' => '',
	                                'line1' => '',
	                                'line2' => '',
	                                'phone' => '',
	                                'city' => '',
	                                'state' => '',
	                                'country' => '',
	                                'postal_code' => '',
	                                'mcc' => '',
	                                'url' => '',
	                                'id_number' => '',
	                                'ssn_last_4' => '',
	                                'front_pic' => '',
	                                'back_pic' => '',
	                                'front' => '',
	                                'back' => '',
	                                'document_front_id' => '',
	                                'document_back_id' => '');
	        if($details) {
	            $request_data = unserialize($details->request_data);
	        }
	        return response()->json(['message' => $details, "status" => true, 'extra_data' => $request_data]);
    	}
    }

    public function uploadImage(Request $request) {
        try {
            $data = $request->image;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $image_name = time().'.png';
            $path = public_path() . "/uploads/profiles/" . $image_name;

            file_put_contents($path, $data);

            return response()->json(['path' => $path, "status" => true]);

        } catch (Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['message' => $msg, "status" => false]);
        }
    }
}
