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
                $input = $request->only('first_name', 'last_name', 'email', 'type', 'status', 'address', 'profile_picture', 'bio');

                //upload image
                if(isset($input['profile_picture']) && is_array($input['profile_picture'])) {
                    $files = $data['profile_picture'][0];
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
