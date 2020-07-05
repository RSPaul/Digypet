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
