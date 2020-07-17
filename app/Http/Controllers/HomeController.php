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
                $input = $request->only('first_name', 'last_name', 'email', 'type', 'status', 'city', 'state', 'zip', 'location', 'profile_picture', 'images', 'bio', 'video_link');

                //upload profile image
                if(isset($input['profile_picture'])) {
                    if(strpos($data['profile_picture'], "data:") !== false) {
                        $files = $data['profile_picture'];
                        list($type, $files) = explode(';', $files);
                        list(, $files)      = explode(',', $files);
                        $file_date = base64_decode($files);
                        $file_type = explode("/", $type);
                                //print_r($file_type);die();
                        $file_name = time().'.' . $file_type[1];
                        $path = public_path() . "/uploads/providers/" . $file_name;
                        file_put_contents($path, $file_date);

                        $input['profile_picture'] = $file_name;
                    }
                }   
                //upload other images
                if(isset($input['images']) && is_array($input['images'])) {
                    $images_array = array();
                    $counter = 1;
                    foreach($input['images'] as $image) {
                        if(strpos($image, "data:") !== false) {
                            $files = $image;
                            list($type, $files) = explode(';', $files);
                            list(, $files)      = explode(',', $files);
                            $file_date = base64_decode($files);
                            $file_type = explode("/", $type);
                                    //print_r($file_type);die();
                            $file_name = $counter . time().'.' . $file_type[1];
                            $path = public_path() . "/uploads/providers/" . $file_name;
                            file_put_contents($path, $file_date);
                            array_push($images_array, $file_name);
                        } else {
                            array_push($images_array, $image);
                        }
                        $counter++;
                    }
                }

                $input['images'] = serialize($images_array);
                User::where(['id' => Auth::user()->id])
                        ->update($input);  
                $response = array(
                        'status'  => true,
                        'message'  => 'Profile updated.'
                    );
                return response()->json($response);
            }
        endif;

    }

    public function updatePassword(Request $request) {
        if (Auth::check()){
            if($request->isMethod('post')) {
                $data = $request->all();
                $input = $request->only('password', 'confirm_password');
                if($input['password'] != '') {
                    if($input['password'] == $input['confirm_password']) {
                        User::where(['id' => Auth::user()->id])
                                ->update(['password' => Hash::make($input['password'])]);
                        $response = array(
                            'status'  => true,
                            'message'  => 'Profile has been changed.'
                        );
                    } else {
                        $response = array(
                            'status'  => false,
                            'message'  => 'Password and confirm password not matched.'
                        );
                    }
                } else {
                    $response = array(
                        'status'  => false,
                        'message'  => 'Password is required.'
                    );
                }

                return response()->json($response);
            }
        }
    }
}
