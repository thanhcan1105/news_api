<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\Product\CustomerController;
use App\Http\Controllers\Product\CategoryController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\BannerController;
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

Route::post('/partner/f88/case', 'API\F88APIController@store');
Route::post('upload/cccd', 'Api\CCCDController@store');
Route::post('destroy/cccd/{cccd}', 'Api\CCCDController@destroy');
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth.jwt'], function () {
    // USER
    Route::get('logout', 'API\UserController@logout');
    Route::get('users', 'API\UserController@index');
    Route::get('user-info', 'API\UserController@getUser');

    // Route::post('update-user/{id}', 'API\UserController@updateUser');
    // Route::post('delete-user/{id}', 'API\UserController@deleteUser');

});

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('customer', [CustomerController::class, 'getCustomer']);
    Route::post('add-customer', [CustomerController::class, 'addCustomer']);
    Route::get('collab', [UserController::class, 'getCollab']);
});


Route::get('/banner', [BannerController::class, 'getBanner']);
Route::get('/category', [CategoryController::class, 'getCategory']);
Route::get('/product', [ProductController::class, 'getProduct']);

Route::post('user/forget-password/send-otp', 'API\UserController@sendOTPForgetPassword');
Route::post('user/forget-password/verify-otp', 'API\UserController@verifyOTPForgetPassword');
Route::post('user/forget-password/verify-code', 'API\UserController@verifyOTP');
