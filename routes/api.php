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
	Route::apiResource('khohang', 'Api\KhohangController');
	Route::apiResource('orders','Api\OrderController');
	Route::get('orders-status','Api\OrderController@getStatus');
	Route::post('orders-status','Api\OrderController@updateStatus');
	// Route::get('doisoat','Api\OrderController@doisoat1donhang');
	Route::get('list-status','Api\OrderController@getListStatus');
	Route::get('getJourney','Api\OrderController@getJourney');

	Route::group(['prefix' => 'doi-soat'], function(){
		Route::post('doi-soat-all','Api\OrderController@doiSoatToanBoOrder');
		Route::post('set-doi-soat','AuthController@setDoiSoat');
		Route::get('get-all-doi-soat','Api\OrderController@getAllDoiSoat');

		Route::get('get-doi-soat-theo-dot-user','Api\OrderController@getDoiSoatTheoDotCua1User');
		Route::get('get-doi-soat-theo-dot-all','Api\OrderController@getDoiSoatTheoDotAll');
	});
	

});
Route::group(['prefix' => 'address'], function(){
	Route::get('/province', 'AddressController@province');
	Route::get('/district', 'AddressController@district');
	Route::get('/commune', 'AddressController@commune');
	Route::get('/find', 'AddressController@findByCommune');


});

// Route::get('{district}', 'AddressController@commune');