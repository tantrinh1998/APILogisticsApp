<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login')->name('login');
    Route::post('signup', 'AuthController@signup');
    Route::get('logout', 'AuthController@logout')->middleware('auth:api');
	Route::get('user/info', 'AuthController@user')->middleware('auth:api');	
});

// Route::get('test','Api\OrderController@getAllDoiSoat');
// Route::get('test','tinhPhiController@test');

Route::get('tinhtien','tinhPhiController@tinhtien');


Route::group( ['middleware'=>'auth:api'],function(){

	// Route::get('test','AuthController@test');
	// Route::apiResource('user','Api\UserController');
	Route::apiResource('khohang', 'Api\KhohangController')->only('index','store','update');
	Route::apiResource('orders','Api\OrderController');
	Route::get('orders-status','Api\OrderController@getStatus');
	Route::post('orders-status','Api\OrderController@updateStatus');
	// Route::get('doisoat','Api\OrderController@doisoat1donhang');
	Route::get('list-status','Api\OrderController@getListStatus');
	Route::post('doi-soat-all','Api\OrderController@doiSoatToanBoOrder');

});
Route::group(['prefix' => 'address'], function(){
	Route::get('/', 'AddressController@province');
	Route::get('{province_code}', 'AddressController@district');
	Route::get('{province_code}/{district_code}', 'AddressController@commune');


});

// Route::get('{district}', 'AddressController@commune');