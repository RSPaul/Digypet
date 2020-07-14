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
* Serach Routes
*/
Route::get('/search', 'SearchController@index')->name('search');
Route::get('/provider/view/{id}', 'SearchController@index')->name('search');
Route::get('/api/getProviders', 'SearchController@getProviders')->name('get_providers');
Route::post('/api/filterProviders', 'SearchController@filterProviders')->name('filter_providers');


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
Route::get('/provider/bookings', 'Provider\ProviderController@dashboard')->name('provider_bookings');
Route::get('/provider/services', 'Provider\ProviderController@dashboard')->name('provider_services');
Route::get('/provider/service/add', 'Provider\ProviderController@dashboard')->name('provider_add_service');
Route::get('/provider/payments', 'Provider\ProviderController@dashboard')->name('provider_payments');
Route::get('/provider/message', 'Provider\ProviderController@dashboard')->name('provider_messages');

/*
* Provider API Routes
*/
Route::get('/api/provider/services', 'Provider\ProviderController@services')->name('provider_add_pet_service');
Route::post('/api/provider/service/add', 'Provider\ProviderController@addPetService')->name('provider_add_pet_service');
