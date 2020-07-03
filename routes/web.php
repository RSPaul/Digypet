<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
* Generic API Routes
*/
Route::get('/api/me', 'HomeController@authUser')->name('auth_user');
Route::post('/api/profile', 'HomeController@updateProfile')->name('update_auth_user');

/*
* Provider Routes
*/
Route::get('/provider', 'Provider\ProviderController@dashboard')->name('provider_dashboard');
Route::get('/provider/profile', 'Provider\ProviderController@dashboard')->name('provider_profile');
