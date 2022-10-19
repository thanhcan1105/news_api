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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/','AdminController@index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
//user


// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth']],function(){
    Route::get('/','AdminController@index')->name('admin');
    // User route

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users','UserController');
    // Product
    Route::get('excel', 'ProductController@getExcelView');
    Route::get('products/export/', 'ProductController@export')->name('products.export');
    Route::post('products/import/', 'ProductController@import')->name('products.import');
    Route::resource('products','ProductController');
    // Banner
    Route::resource('banners','BannerController');
    // CCCD
    Route::get('cccd', 'CCCDController@index')->name('cccds.index');
    Route::post('cccd/approve', 'CCCDController@approveUser')->name('cccds.approve');
    Route::post('cccd/reject', 'CCCDController@rejectUser')->name('cccds.reject');
    
   
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
