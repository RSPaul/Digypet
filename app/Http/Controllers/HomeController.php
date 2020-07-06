<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function authUser(Request $request) {
        if (Auth::check()):
            $user = User::where(['id' => Auth::user()->id])->first();
            $user['pets'] = unserialize($user['pets']);
            $user['service_pricing'] = unserialize($user['service_pricing']);
            $user['images'] = unserialize($user['images']);
            return response()->json($user);
        endif;
    }

    public function updateProfile(Request $request) {
        if (Auth::check()):
            if($request->isMethod('post')) {
                $data = $request->all();
                $input = $request->only('first_name', 'last_name', 'email', 'type', 'status', 'address', 'pets', 'service_pricing', 'images', 'profile_picture', 'bio',);

                $input['pets'] = serialize($input['pets']);
                $input['service_pricing'] = serialize($input['service_pricing']);

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
                User::where(['id' => Auth::user()->id])
                        ->update($input);  

                if($data['password'] != '') {
                    if($data['password'] == $data['confirm_password']) {
                        User::where(['id' => $profile->id])
                                ->update(['password' => Hash::make($data['password'])]);
                        $response = array(
                            'status'  => true,
                            'message'  => 'Profile updated.'
                        );
                    } else {
                        $response = array(
                            'status'  => false,
                            'message'  => 'Password and confirm password not matched.'
                        );
                    }
                } else {
                    $response = array(
                        'status'  => true,
                        'message'  => 'Profile updated.'
                    );
                }            
                return response()->json($response);
            }
        endif;

    }
}
